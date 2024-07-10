<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $details = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?habitat $habitat_id = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?race $race_id = null;

    /**
     * @var Collection<int, AnimalReport>
     */
    #[ORM\OneToMany(targetEntity: AnimalReport::class, mappedBy: 'animal_id')]
    private Collection $animalReports;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'animal_id', orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, FoodRepport>
     */
    #[ORM\OneToMany(targetEntity: FoodRepport::class, mappedBy: 'animal_id', orphanRemoval: true)]
    private Collection $foodRepports;

    public function __construct()
    {
        $this->animalReports = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->foodRepports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getHabitatId(): ?habitat
    {
        return $this->habitat_id;
    }

    public function setHabitatId(?habitat $habitat_id): static
    {
        $this->habitat_id = $habitat_id;

        return $this;
    }

    public function getRaceId(): ?race
    {
        return $this->race_id;
    }

    public function setRaceId(?race $race_id): static
    {
        $this->race_id = $race_id;

        return $this;
    }

    /**
     * @return Collection<int, AnimalReport>
     */
    public function getAnimalReports(): Collection
    {
        return $this->animalReports;
    }

    public function addAnimalReport(AnimalReport $animalReport): static
    {
        if (!$this->animalReports->contains($animalReport)) {
            $this->animalReports->add($animalReport);
            $animalReport->setAnimalId($this);
        }

        return $this;
    }

    public function removeAnimalReport(AnimalReport $animalReport): static
    {
        if ($this->animalReports->removeElement($animalReport)) {
            // set the owning side to null (unless already changed)
            if ($animalReport->getAnimalId() === $this) {
                $animalReport->setAnimalId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnimalId($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnimalId() === $this) {
                $image->setAnimalId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FoodRepport>
     */
    public function getFoodRepports(): Collection
    {
        return $this->foodRepports;
    }

    public function addFoodRepport(FoodRepport $foodRepport): static
    {
        if (!$this->foodRepports->contains($foodRepport)) {
            $this->foodRepports->add($foodRepport);
            $foodRepport->setAnimalId($this);
        }

        return $this;
    }

    public function removeFoodRepport(FoodRepport $foodRepport): static
    {
        if ($this->foodRepports->removeElement($foodRepport)) {
            // set the owning side to null (unless already changed)
            if ($foodRepport->getAnimalId() === $this) {
                $foodRepport->setAnimalId(null);
            }
        }

        return $this;
    }
}
