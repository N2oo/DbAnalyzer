<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\DependOnRepository;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use App\Entity\DTO\DependOn\DependOnMultipleDTO;
use App\Service\Processor\DependOnMultipleProcessor;
use App\Entity\DTO\DependOn\DependOnMultipleResponseDTO;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[
    ORM\Entity(repositoryClass: DependOnRepository::class),
    ApiResource(
    shortName: "Dépendance",
    uriTemplate: "depend_on",
    operations: [
        new Get(uriTemplate: "depend_on/{id}"),
        new GetCollection(),
        new Post(),
        new Post(
            uriTemplate:'depend_on/multiple',
            openapi: new Operation(
                summary:"Envoi de multiple instances de depend_on",
                description: "Utiliez ce endpoint pour envoyer plusieurs depend_ons à la fois"
            ),
            input: DependOnMultipleDTO::class,
            output: DependOnMultipleResponseDTO::class,
            processor: DependOnMultipleProcessor::class
        )
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
    
    #[SerializedName('btype')]
    private ?string $bType = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('dtype')]
    private ?string $dType = null;

    #[ORM\Column]
    
    #[SerializedName('btabid')]
    private ?int $bTableIdOriginal = null;

    #[ORM\Column]
    
    #[SerializedName('dtabid')]
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
