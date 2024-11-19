<?php

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


#[MongoDB\Document(db: "zoo", collection: "comment")]
class comment {
    
    #[MongoDB\Id]
    protected ?string $id;

    #[MongoDB\Field(type: "string")]
    protected ?string $name;

    #[MongoDB\Field(type: "string")]
    protected ?string $lastname;

    #[MongoDB\Field(type: "string")]
    private ?string $comment = null;

    #[MongoDB\Field(type: "bool")]
    private ?bool $validation = false;

    #[MongoDB\Field(type: "string")]
    private ?string $Email = null;

    #[MongoDB\Field(type: "int")]
    private ?int $rating = null;

    #[MongoDB\Field(type: "date")]
    protected ?\DateTime $createdAt;
    
    public function getId(): ?string
    {
      return $this->id;
    }
    
    public function setId(string $id): static
    {
      $this->id = $id;
      
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
    
    public function getLastname(): ?string
    {
      return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
      $this->lastname = $lastname;
      
      return $this;
    }
    
    public function getComment(): ?string
    {
      return $this->comment;
    }
    
    public function setComment(string $comment): static
    {
      $this->comment = $comment;
      
      return $this;
    }
    
    public function getValidation(): ?bool
    {
      return $this->validation;
    }
    
    public function setValidation(bool $validation): static
    {
      $this->validation = $validation;
      
      return $this;
    }
    
    public function getEmail(): ?string
    {
      return $this->Email;
    }
    
    public function setEmail(string $Email): static
    {
      $this->Email = $Email;
      
      return $this;
    }
    
    public function getRating(): ?int
    {
      return $this->rating;
    }
    
    public function setRating(int $rating): static
    {
      $this->rating = $rating;
      
      return $this;
    }
    
    public function getCreatedAt(): ?\DateTime
    {
      return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTime $createdAt): static
    {
      $this->createdAt = $createdAt;
      
      return $this;
    }
 
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
  }
  