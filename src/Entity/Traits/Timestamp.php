<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Timestamp
{
  #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
  private $timestamp;

  public function getTimestamp(): ?\DateTimeImmutable
  {
      return $this->timestamp;
  }

  public function setTimestamp(\DateTimeImmutable $timestamp): self
  {
      $this->timestamp = $timestamp;

      return $this;
  }

  #[ORM\PrePersist]
  public function setTimestampValue(): void
  {
      if ($this->timestamp === null) {
          $this->timestamp = new \DateTimeImmutable();
      }
  }
}
