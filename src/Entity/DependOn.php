<?php

namespace App\Entity;

use App\Repository\DependOnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DependOnRepository::class)]
class DependOn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $bType = null;

    #[ORM\Column(length: 255)]
    private ?string $dType = null;

    #[ORM\Column]
    private ?int $bTableId = null;

    #[ORM\Column]
    private ?int $dTableId = null;

    #[ORM\ManyToOne(inversedBy: 'dependencies')]
    private ?Table $bTable = null;

    #[ORM\ManyToOne(inversedBy: 'dependOns')]
    private ?Table $dTable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBType(): ?string
    {
        return $this->bType;
    }

    public function setBType(string $bType): static
    {
        $this->bType = $bType;

        return $this;
    }

    public function getDType(): ?string
    {
        return $this->dType;
    }

    public function setDType(string $dType): static
    {
        $this->dType = $dType;

        return $this;
    }

    public function getBTableId(): ?int
    {
        return $this->bTableId;
    }

    public function setBTableId(int $bTableId): static
    {
        $this->bTableId = $bTableId;

        return $this;
    }

    public function getDTableId(): ?int
    {
        return $this->dTableId;
    }

    public function setDTableId(int $dTableId): static
    {
        $this->dTableId = $dTableId;

        return $this;
    }

    public function getBTable(): ?Table
    {
        return $this->bTable;
    }

    public function setBTable(?Table $bTable): static
    {
        $this->bTable = $bTable;

        return $this;
    }

    public function getDTable(): ?Table
    {
        return $this->dTable;
    }

    public function setDTable(?Table $dTable): static
    {
        $this->dTable = $dTable;

        return $this;
    }
}
