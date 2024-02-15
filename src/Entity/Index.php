<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\IndexRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use App\Entity\DTO\Index\IndexMultipleDTO;
use App\Service\Processor\IndexMultipleProcessor;
use App\Entity\DTO\Index\IndexMultipleResponseDTO;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: IndexRepository::class),
    ApiResource(
        shortName: "Index",
        operations:[
            new Get(uriTemplate:"index/{id}"),
            new GetCollection(),
            new Post(),
            new Post(
                uriTemplate:'index/multiple',
                openapi: new Operation(
                    summary:"Envoi de multiple instances de index"
                ),
                input: IndexMultipleDTO::class,
                output: IndexMultipleResponseDTO::class,
                processor: IndexMultipleProcessor::class
            ),
            ])
]
class Index
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('idxname')]
    private ?string $indexName = null;

    #[ORM\Column(length: 255)]
    private ?string $owner = null;

    #[ORM\Column]
    #[SerializedName('tabid')]
    private ?int $tableId = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('idxtype')]
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

    #[ORM\ManyToOne]
    private ?Column $column1 = null;

    #[ORM\ManyToOne]
    private ?Column $column2 = null;

    #[ORM\ManyToOne]
    private ?Column $column3 = null;

    #[ORM\ManyToOne]
    private ?Column $column4 = null;

    #[ORM\ManyToOne]
    private ?Column $column5 = null;

    #[ORM\ManyToOne]
    private ?Column $column6 = null;

    #[ORM\ManyToOne]
    private ?Column $column7 = null;

    #[ORM\ManyToOne]
    private ?Column $column8 = null;

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

    public function getResolvedIndexType(): ?string
    {
        $idxType = $this->getIndexType();
        return match(true)
        {
            $idxType == "U" =>"Unique",
            $idxType == "D" =>"Duplicates allowed",
            $idxType == "G" =>"Nonbitmap generalized-key index",
            $idxType == "g" =>"Bitmap generalized-key index",
            $idxType == "u" =>"unique, bitmap",
            $idxType == "d" =>"nonunique, bitmap ",
            default => ""
        };
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

    public function getColumn1(): ?Column
    {
        return $this->column1;
    }

    public function setColumn1(?Column $column1): static
    {
        $this->column1 = $column1;

        return $this;
    }

    public function getColumn2(): ?Column
    {
        return $this->column2;
    }

    public function setColumn2(?Column $column2): static
    {
        $this->column2 = $column2;

        return $this;
    }

    public function getColumn3(): ?Column
    {
        return $this->column3;
    }

    public function setColumn3(?Column $column3): static
    {
        $this->column3 = $column3;

        return $this;
    }

    public function getColumn4(): ?Column
    {
        return $this->column4;
    }

    public function setColumn4(?Column $column4): static
    {
        $this->column4 = $column4;

        return $this;
    }

    public function getColumn5(): ?Column
    {
        return $this->column5;
    }

    public function setColumn5(?Column $column5): static
    {
        $this->column5 = $column5;

        return $this;
    }

    public function getColumn6(): ?Column
    {
        return $this->column6;
    }

    public function setColumn6(?Column $column6): static
    {
        $this->column6 = $column6;

        return $this;
    }

    public function getColumn7(): ?Column
    {
        return $this->column7;
    }

    public function setColumn7(?Column $column7): static
    {
        $this->column7 = $column7;

        return $this;
    }

    public function getColumn8(): ?Column
    {
        return $this->column8;
    }

    public function setColumn8(?Column $column8): static
    {
        $this->column8 = $column8;

        return $this;
    }
}
