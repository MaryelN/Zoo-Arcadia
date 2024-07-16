<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[Vich\UploadableField(mapping: "images", fileNameProperty: "imageName", size: "imageSize")]
    private ?File $imageFile = null;
    
    #[ORM\Column(length: 100, type: 'string')]
    private ?string $imageName = null;

    #[ORM\Column]
    private ?int $imageSize = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
        $this->createdAt = new \DateTime();
    }

    #[ORM\PreUpdate ]
    public function preUpdate()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\ManyToOne(inversedBy: 'Images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?animal $animal_id = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getImageSize(): ?Int
    {
        return $this->imageSize;
    }

    public function setImageSize(?Int $imageSize): static
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

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
}
