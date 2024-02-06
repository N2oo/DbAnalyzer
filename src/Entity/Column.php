<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ColumnRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use App\Entity\DTO\Column\ColumnMultipleDTO;
use App\Service\Processor\ColumnMultipleProcessor;
use App\Entity\DTO\Column\ColumnMultipleResponseDTO;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: ColumnRepository::class),
    ApiResource(
    shortName: "Colonne",
    uriTemplate: "column",
    operations: [
        new Get(uriTemplate: "column/{id}"),
        new GetCollection(),
        new Post(),
        new Post(
            uriTemplate:'column/multiple',
            openapi: new Operation(
                summary:"Envoi de multiple instances de column",
                description: "Utiliez ce endpoint pour envoyer plusieurs columns à la fois"
            ),
            input: ColumnMultipleDTO::class,
            output: ColumnMultipleResponseDTO::class,
            processor: ColumnMultipleProcessor::class
        )
    ]),
    ApiResource(
        shortName: "Colonne",
        openapiContext:[
            "summary"=> "Résolution des colonnes d'une table",
            "secription"=> "Résolution des colonnes affairantes à une table"
        ],
        uriTemplate:"table/{id}/columns",
        uriVariables:["id"=>new Link(fromClass:Table::class,fromProperty:"id")],
        operations: [
            new GetCollection()
        ]
    )
]
#[ORM\Table(name: '`column`')]
class Column
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('colname')]
    private ?string $columnName = null;

    #[ORM\Column]
    
    #[SerializedName('tabid')]
    private ?int $tableId = null;

    #[ORM\Column]
    
    #[SerializedName('colno')]
    private ?int $columnNumber = null;

    #[ORM\Column]
    
    #[SerializedName('coltype')]
    private ?int $columnType = null;

    #[ORM\Column]
    
    #[SerializedName('collength')]
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
