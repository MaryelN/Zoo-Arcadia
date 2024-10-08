<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2, 
        max: 50, 
        minMessage:"Votre nom doit comporter au moins 2 caractères", 
        maxMessage: "Limite de caractères atteinte")]
    private ?string $fullName = null;

    #[ORM\Column(length: 180)]
    #[Assert\Email(
        message: "L'adresse email '{{ value }}' n'est pas valide.",
        mode: "strict"
    )]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $subject = null;

    #[ORM\Column(length: 180, type: "text")]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2, 
        max: 180, 
        minMessage:"Votre message doit comporter au moins 2 caractères", 
        maxMessage: "Limite de caractères atteinte")]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
