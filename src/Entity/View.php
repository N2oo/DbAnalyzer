<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ViewRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[
    ORM\Entity(repositoryClass: ViewRepository::class),
    ApiResource(
        shortName: "Vue",
        description: "Informations sur la constitution de la vue",
        uriTemplate: "view",
        operations:[
            new Get(uriTemplate:"view/{id}"),
            new GetCollection(),
            new Post()
        ])
]
class View
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    
    #[SerializedName('tabid')]
    private ?int $tableId = null;

    #[ORM\Column]
    
    #[SerializedName('seqno')]
    private ?int $sequenceNumber = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('viewtext')]
    private ?string $viewText = null;

    #[ORM\ManyToOne(inversedBy: 'views')]
    private ?Table $tableElement = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(int $sequenceNumber): static
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }

    public function getViewText(): ?string
    {
        return $this->viewText;
    }

    public function setViewText(string $viewText): static
    {
        $this->viewText = $viewText;

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
