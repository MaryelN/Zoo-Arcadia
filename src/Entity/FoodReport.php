<?php

namespace App\Entity;

use App\Repository\FoodReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodReportRepository::class)]
class FoodReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_time = null;

    #[ORM\Column(length: 50)]
    private ?string $food_quantity = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $details = null;

    #[ORM\ManyToOne(inversedBy: 'FoodReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?animal $animal_id = null;

    #[ORM\ManyToOne(inversedBy: 'FoodReports')]
    private ?user $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->date_time;
    }

    public function setDateTime(\DateTimeInterface $date_time): static
    {
        $this->date_time = $date_time;

        return $this;
    }

    public function getFoodQuantity(): ?string
    {
        return $this->food_quantity;
    }

    public function setFoodQuantity(string $food_quantity): static
    {
        $this->food_quantity = $food_quantity;

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

    public function getAnimalId(): ?Animal
    {
        return $this->animal_id;
    }

    public function setAnimalId(?Animal $animal_id): static
    {
        $this->animal_id = $animal_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
