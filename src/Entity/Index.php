<?php

namespace App\Entity;

use App\Repository\IndexRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndexRepository::class)]
class Index
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $indexName = null;

    #[ORM\Column(length: 255)]
    private ?string $owner = null;

    #[ORM\Column]
    private ?int $tableId = null;

    #[ORM\Column(length: 255)]
    private ?string $indexType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clustered = null;

    #[ORM\Column]
    private ?int $part1 = null;

    #[ORM\Column]
    private ?int $part2 = null;

    #[ORM\Column]
    private ?int $part3 = null;

    #[ORM\Column]
    private ?int $part4 = null;

    #[ORM\Column]
    private ?int $part5 = null;

    #[ORM\Column]
    private ?int $part6 = null;

    #[ORM\Column]
    private ?int $part7 = null;

    #[ORM\Column]
    private ?int $part8 = null;

    #[ORM\ManyToOne(inversedBy: 'indexes')]
    private ?Table $tableElement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIndexName(): ?string
    {
        return $this->indexName;
    }

    public function setIndexName(string $indexName): static
    {
        $this->indexName = $indexName;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getTableId(): ?int
    {
        return $this->tableId;
    }

    public function setTableId(int $tableId): static
    {
        $this->tableId = $tableId;

        return $this;
    }

    public function getIndexType(): ?string
    {
        return $this->indexType;
    }

    public function setIndexType(string $indexType): static
    {
        $this->indexType = $indexType;

        return $this;
    }

    public function getClustered(): ?string
    {
        return $this->clustered;
    }

    public function setClustered(?string $clustered): static
    {
        $this->clustered = $clustered;

        return $this;
    }

    public function getPart1(): ?int
    {
        return $this->part1;
    }

    public function setPart1(int $part1): static
    {
        $this->part1 = $part1;

        return $this;
    }

    public function getPart2(): ?int
    {
        return $this->part2;
    }

    public function setPart2(int $part2): static
    {
        $this->part2 = $part2;

        return $this;
    }

    public function getPart3(): ?int
    {
        return $this->part3;
    }

    public function setPart3(int $part3): static
    {
        $this->part3 = $part3;

        return $this;
    }

    public function getPart4(): ?int
    {
        return $this->part4;
    }

    public function setPart4(int $part4): static
    {
        $this->part4 = $part4;

        return $this;
    }

    public function getPart5(): ?int
    {
        return $this->part5;
    }

    public function setPart5(int $part5): static
    {
        $this->part5 = $part5;

        return $this;
    }

    public function getPart6(): ?int
    {
        return $this->part6;
    }

    public function setPart6(int $part6): static
    {
        $this->part6 = $part6;

        return $this;
    }

    public function getPart7(): ?int
    {
        return $this->part7;
    }

    public function setPart7(int $part7): static
    {
        $this->part7 = $part7;

        return $this;
    }

    public function getPart8(): ?int
    {
        return $this->part8;
    }

    public function setPart8(int $part8): static
    {
        $this->part8 = $part8;

        return $this;
    }

    public function getTableElement(): ?Table
    {
        return $this->tableElement;
    }

    public function setTableElement(?Table $tableElement): static
    {
        $this->tableElement = $tableElement;

        return $this;
    }
}
