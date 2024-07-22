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

    #[ORM\Column(nullable: true)]
    private ?int $votes = 0;

    #[ORM\ManyToOne(inversedBy: 'Animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitat $habitat = null;

    #[ORM\ManyToOne(inversedBy: 'Animals')]
    private ?Race $race = null;

    #[ORM\OneToMany(targetEntity: Image::class, mappedBy:'animal', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, AnimalReport>
     */
    #[ORM\OneToMany(targetEntity: AnimalReport::class, mappedBy: 'Animal_id', orphanRemoval: true)]
    private Collection $animalReports;

    /**
     * @var Collection<int, FoodReport>
     */
    #[ORM\OneToMany(targetEntity: FoodReport::class, mappedBy: 'Animal_id', orphanRemoval: true)]
    private Collection $foodReports;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->animalReports = new ArrayCollection();
        $this->foodReports = new ArrayCollection();
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

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

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
            $image->setAnimal($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnimal() === $this) {
                $image->setAnimal(null);
            }
        }

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
     * @return Collection<int, FoodReport>
     */
    public function getFoodReports(): Collection
    {
        return $this->foodReports;
    }

    public function addFoodReport(FoodReport $foodReport): static
    {
        if (!$this->foodReports->contains($foodReport)) {
            $this->foodReports->add($foodReport);
            $foodReport->setAnimalId($this);
        }

        return $this;
    }

    public function removeFoodReport(FoodReport $foodReport): static
    {
        if ($this->foodReports->removeElement($foodReport)) {
            // set the owning side to null (unless already changed)
            if ($foodReport->getAnimalId() === $this) {
                $foodReport->setAnimalId(null);
            }
        }

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(?int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
