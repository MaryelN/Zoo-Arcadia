<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestamp;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(unique: true, type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, AnimalReport>
     */
    #[ORM\OneToMany(targetEntity: AnimalReport::class, mappedBy: 'User_id')]
    private Collection $animalReports;

    /**
     * @var Collection<int, FoodReport>
     */
    #[ORM\OneToMany(targetEntity: FoodReport::class, mappedBy: 'User_id')]
    private Collection $foodReports;

    public function __construct()
    {
        $this->animalReports = new ArrayCollection();
        $this->foodReports = new ArrayCollection();
        $this->timestamp = new \DateTimeImmutable();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $foodReport->setUserId($this);
        }

        return $this;
    }

    public function removeFoodReport(FoodReport $foodReport): static
    {
        if ($this->foodReports->removeElement($foodReport)) {
            // set the owning side to null (unless already changed)
            if ($foodReport->getUserId() === $this) {
                $foodReport->setUserId(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
