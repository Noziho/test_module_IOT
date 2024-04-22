<?php

namespace App\Entity;

use App\Repository\OperatingHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperatingHistoryRepository::class)]
class OperatingHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $duration = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $consumedData = null;

    #[ORM\Column(nullable: true)]
    private ?int $dataSent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getConsumedData(): ?int
    {
        return $this->consumedData;
    }

    public function setConsumedData(?int $consumedData): static
    {
        $this->consumedData = $consumedData;

        return $this;
    }

    public function getDataSent(): ?int
    {
        return $this->dataSent;
    }

    public function setDataSent(?int $dataSent): static
    {
        $this->dataSent = $dataSent;

        return $this;
    }
}
