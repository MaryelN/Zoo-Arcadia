<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?role $role_id = null;

    /**
     * @var Collection<int, AnimalReport>
     */
    #[ORM\OneToMany(targetEntity: AnimalReport::class, mappedBy: 'user_id')]
    private Collection $animalReports;

    /**
     * @var Collection<int, FoodRepport>
     */
    #[ORM\OneToMany(targetEntity: FoodRepport::class, mappedBy: 'user_id')]
    private Collection $foodRepports;

    public function __construct()
    {
        $this->animalReports = new ArrayCollection();
        $this->foodRepports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoleId(): ?role
    {
        return $this->role_id;
    }

    public function setRoleId(?role $role_id): static
    {
        $this->role_id = $role_id;

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
            $animalReport->setUserId($this);
        }

        return $this;
    }

    public function removeAnimalReport(AnimalReport $animalReport): static
    {
        if ($this->animalReports->removeElement($animalReport)) {
            // set the owning side to null (unless already changed)
            if ($animalReport->getUserId() === $this) {
                $animalReport->setUserId(null);
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
            $foodRepport->setUserId($this);
        }

        return $this;
    }

    public function removeFoodRepport(FoodRepport $foodRepport): static
    {
        if ($this->foodRepports->removeElement($foodRepport)) {
            // set the owning side to null (unless already changed)
            if ($foodRepport->getUserId() === $this) {
                $foodRepport->setUserId(null);
            }
        }

        return $this;
    }
}
