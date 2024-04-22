<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Detail>
     */
    #[ORM\OneToMany(targetEntity: Detail::class, mappedBy: 'module')]
    private Collection $detail;

    /**
     * @var Collection<int, OperatingHistory>
     */
    #[ORM\OneToMany(targetEntity: OperatingHistory::class, mappedBy: 'module')]
    private Collection $OperatingHistory;

    public function __construct()
    {
        $this->detail = new ArrayCollection();
        $this->OperatingHistory = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetail(): Collection
    {
        return $this->detail;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->detail->contains($detail)) {
            $this->detail->add($detail);
            $detail->setModule($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->detail->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getModule() === $this) {
                $detail->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OperatingHistory>
     */
    public function getOperatingHistory(): Collection
    {
        return $this->OperatingHistory;
    }

    public function addOperatingHistory(OperatingHistory $operatingHistory): static
    {
        if (!$this->OperatingHistory->contains($operatingHistory)) {
            $this->OperatingHistory->add($operatingHistory);
            $operatingHistory->setModule($this);
        }

        return $this;
    }

    public function removeOperatingHistory(OperatingHistory $operatingHistory): static
    {
        if ($this->OperatingHistory->removeElement($operatingHistory)) {
            // set the owning side to null (unless already changed)
            if ($operatingHistory->getModule() === $this) {
                $operatingHistory->setModule(null);
            }
        }

        return $this;
    }
}
