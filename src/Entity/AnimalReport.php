<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\AnimalReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalReportRepository::class)]
class AnimalReport
{
    use Timestamp;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $proposed_food = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $proposed_quantity = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $details = null;

    #[ORM\ManyToOne(inversedBy: 'animalReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?animal $animal_id = null;

    #[ORM\ManyToOne(inversedBy: 'animalReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProposedFood(): ?string
    {
        return $this->proposed_food;
    }

    public function setProposedFood(string $proposed_food): static
    {
        $this->proposed_food = $proposed_food;

        return $this;
    }

    public function getProposedQuantity(): ?string
    {
        return $this->proposed_quantity;
    }

    public function setProposedQuantity(?string $proposed_quantity): static
    {
        $this->proposed_quantity = $proposed_quantity;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getAnimalId(): ?animal
    {
        return $this->animal_id;
    }

    public function setAnimalId(?animal $animal_id): static
    {
        $this->animal_id = $animal_id;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
