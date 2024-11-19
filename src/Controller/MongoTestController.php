<?php
namespace App\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MongoTestController extends AbstractController
{
    #[Route('/test-mongo', name: 'test_mongo')]
    public function test(DocumentManager $dm): Response
    {
        try {
            $database = $dm->getClient()->listDatabases();
            return new Response('<pre>' . print_r($database, true) . '</pre>');
        } catch (\Exception $e) {
            return new Response('MongoDB Connection Failed: ' . $e->getMessage());
        }
    }
}
