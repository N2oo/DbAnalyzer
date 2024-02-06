<?php

namespace App\Entity;

use App\Repository\DependOnRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;

#[
    ORM\Entity(repositoryClass: DependOnRepository::class),
    ApiResource(
    uriTemplate: "depend_on",
    operations: [
        new Get(uriTemplate: "depend_on/{id}"),
        new GetCollection(),
        new Post()
    ]
)
]
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
    private ?int $bTableIdOriginal = null;

    #[ORM\Column]
    private ?int $dTableIdOriginal = null;

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

    public function getBTableIdOriginal(): ?int
    {
        return $this->bTableIdOriginal;
    }

    public function setBTableIdOriginal(int $bTableIdOriginal): static
    {
        $this->bTableIdOriginal = $bTableIdOriginal;

        return $this;
    }

    public function getDTableIdOriginal(): ?int
    {
        return $this->dTableIdOriginal;
    }

    public function setDTableIdOriginal(int $dTableIdOriginal): static
    {
        $this->dTableIdOriginal = $dTableIdOriginal;

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