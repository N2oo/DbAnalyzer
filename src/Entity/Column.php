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
        shortName: "Table",
        openapiContext:[
            "summary"=> "Résolution des colonnes d'une table",
            "secription"=> "Résolution des colonnes affairantes à une table"
        ],
        uriTemplate:"table/{id}/columns",
        uriVariables:["id"=>new Link(fromClass:Table::class, fromProperty:"id",toClass:self::class,toProperty:"tableElement")],
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

    public function getResolvedColumnType():string
    {
        return match($this->getColumnType()){
            0 => "CHAR",
            1 => "SMALLINT",
            2 => "INTEGER",
            3 => "FLOAT",
            4 => "SMALLFLOAT",
            5 => "DECIMAL",
            6 => "SERIAL",
            7 => "DATE",
            8 => "MONEY",
            9 => "NULL",
            10 => "DATETIME",
            11 => "BYTE",
            12 => "TEXT",
            13 => "VARCHAR",
            14 => "INTERVAL",
            15 => "NCHAR",
            16 => "NVARCHAR",
            17 => "INT8",
            18 => "SERIAL8",
            19 => "SET",
            20 => "MULTISET",
            21 => "LIST",
            22 => "ROW (unnamed)",
            23 => "COLLECTION",
            40 => "LVARCHAR fixed-length opaque types 2",
            41 => "BLOB, BOOLEAN, CLOB variable-length opaque types 2",
            43 => "LVARCHAR (client-side only)",
            45 => "BOOLEAN",
            52 => "BIGINT",
            53 => "BIGSERIAL 1",
            2061 => "IDSSECURITYLABEL 2, 3",
            4118 => "ROW (named)",
            default => "INCONNU"
        };
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
