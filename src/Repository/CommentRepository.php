<?php

namespace App\Repository;

use App\Document\comment;
use MongoDB\Collection;
use Doctrine\ODM\MongoDB\DocumentManager;

class CommentRepository
{
    private $dm;      
    private $repository; 

    public function __construct(DocumentManager $documentManager)
    {
        $this->dm = $documentManager;
        $this->repository = $documentManager->getRepository(comment::class);
    }

    public function findLatestComment(int $limit = 3): array
    {
        return $this->repository->findBy(
            ['validation' => true],   
            ['createdAt' => 'desc'],
            $limit                   
        );
    }
}
