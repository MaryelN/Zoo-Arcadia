<?php

namespace App\Service;

class JWTService
{
    public function generate(array $header, array $payload, string $secret, int $validity = 10800): string
    {
          // Ensure user_id is set in the payload
        if (!isset($payload['user_id'])) {
            throw new \Exception('User ID is missing from the payload');
        }

        if ($validity > 0) {
            $now = new \DateTimeImmutable();
            $expiration = $now->getTimestamp() + $validity; 
            
            $payload['iat'] = $now->getTimestamp();
            $payload['expiration'] = $expiration;
        } 

        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        $secret = base64_encode($secret);
        $signature = hash_hmac('sha256', "$base64Header.$base64Payload", $secret, true);

        $base64Signature = base64_encode($signature);
        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }

    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }

    public function getPayload(string $token): array
    {
        $array = explode('.', $token);
        $payload = json_decode(base64_decode($array[1]), true); // Corrected to decode the payload
        return $payload;
    }

    public function getHeader(string $token): array
    {
        $array = explode('.', $token);
        $header = json_decode(base64_decode($array[0]), true);
        return $header;
    }

    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);
        $now = new \DateTimeImmutable();
        return $payload['expiration'] < $now->getTimestamp();
    }

    public function checkSignature(string $token, string $secret): bool
    {
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        $verifyToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifyToken;
    }
}
