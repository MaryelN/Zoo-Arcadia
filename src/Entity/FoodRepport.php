<?php

namespace App\Entity;

use App\Repository\FoodRepportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodRepportRepository::class)]
class FoodRepport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_hour = null;

    #[ORM\Column(length: 50)]
    private ?string $food_quantity = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $details = null;

    #[ORM\ManyToOne(inversedBy: 'foodRepports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?animal $animal_id = null;

    #[ORM\ManyToOne(inversedBy: 'foodRepports')]
    private ?user $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHour(): ?\DateTimeInterface
    {
        return $this->date_hour;
    }

    public function setDateHour(\DateTimeInterface $date_hour): static
    {
        $this->date_hour = $date_hour;

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
