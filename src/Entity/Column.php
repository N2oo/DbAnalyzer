<?php

namespace App\Entity;

use App\Repository\ColumnRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: ColumnRepository::class),
    ApiResource(
    uriTemplate: "column",
    operations: [
        new Get(uriTemplate: "column/{id}"),
        new GetCollection(),
        new Post()
    ]
)]
#[ORM\Table(name: '`column`')]
class Column
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $columnName = null;

    #[ORM\Column]
    private ?int $tableId = null;

    #[ORM\Column]
    private ?int $columnNumber = null;

    #[ORM\Column]
    private ?int $columnType = null;

    #[ORM\Column]
    private ?int $columnLength = null;

    #[ORM\ManyToOne(inversedBy: 'columns')]
    private ?Table $tableElement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColumnName(): ?string
    {
        return $this->columnName;
    }

    public function setColumnName(string $columnName): static
    {
        $this->columnName = $columnName;

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

    public function getColumnNumber(): ?int
    {
        return $this->columnNumber;
    }

    public function setColumnNumber(int $columnNumber): static
    {
        $this->columnNumber = $columnNumber;

        return $this;
    }

    public function getColumnType(): ?int
    {
        return $this->columnType;
    }

    public function setColumnType(int $columnType): static
    {
        $this->columnType = $columnType;

        return $this;
    }

    public function getColumnLength(): ?int
    {
        return $this->columnLength;
    }

    public function setColumnLength(int $columnLength): static
    {
        $this->columnLength = $columnLength;

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