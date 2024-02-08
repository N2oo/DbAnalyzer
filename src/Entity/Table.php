<?php

namespace App\Entity;

use App\Entity\View;
use App\Entity\Index;
use App\Entity\Column;
use App\Entity\DependOn;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TableRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use App\Entity\DTO\Table\TableMultipleDTO;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Service\Processor\TableMultipleProcessor;
use App\Entity\DTO\Table\TableMultipleResponseDTO;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
/**
 * Méthode pour la procession de multiples tables
 * https://github.com/api-platform/api-platform/issues/294
 */

#[ApiResource(
    shortName: "Table",
    uriTemplate: "table",
    operations:[
        new Get(uriTemplate:"table/{id}"),
        new GetCollection(),
        new Post(),
        new Post(
            uriTemplate:'table/multiple',
            openapi: new Operation(
                summary:"Envoi de multiple instances de Table",
                description: "Utiliez ce endpoint pour envoyer plusieurs tables à la fois"
            ),
            input: TableMultipleDTO::class,
            output: TableMultipleResponseDTO::class,
            processor: TableMultipleProcessor::class
        )
    ])
]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[SerializedName('tabname')]
    private ?string $tableName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    #[SerializedName('dirpath')]
    private ?string $dbFileName = null;

    #[ORM\Column]
    
    #[SerializedName('tabid')]
    private ?int $tabId = null;

    #[ORM\Column]
    
    #[SerializedName('rowsize')]
    private ?int $rowSize = null;

    #[ORM\Column]
    
    #[SerializedName('ncols')]
    private ?int $numberRows = null;

    #[ORM\Column]
    
    #[SerializedName('created')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $version = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    #[SerializedName('tabtype')]
    private ?string $tableType = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    #[SerializedName('audpath')]
    private ?string $audPath = null;

    #[ORM\OneToMany(mappedBy: 'tableElement', targetEntity: Column::class,cascade:["persist"])]
    private Collection $columns;

    #[ORM\OneToMany(mappedBy: 'tableElement', targetEntity: Index::class,cascade:["persist"])]
    private Collection $indexes;

    #[ORM\OneToMany(mappedBy: 'tableElement', targetEntity: View::class,cascade:["persist"])]
    #[OrderBy(["sequenceNumber"=>"ASC"])]
    private Collection $views;

    #[ORM\OneToMany(mappedBy: 'bTable', targetEntity: DependOn::class,cascade:["persist"])]
    private Collection $dependencies;

    #[ORM\OneToMany(mappedBy: 'dTable', targetEntity: DependOn::class,cascade:["persist"])]
    private Collection $dependOns;

    #[ORM\OneToMany(mappedBy: 'tableElement', targetEntity: Detail::class, cascade:["persist"])]
    private Collection $details;

    public function __construct()
    {
        $this->columns = new ArrayCollection();
        $this->indexes = new ArrayCollection();
        $this->views = new ArrayCollection();
        $this->dependencies = new ArrayCollection();
        $this->dependOns = new ArrayCollection();
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableName(): ?string
    {
        return $this->tableName;
    }

    public function setTableName(string $tableName): static
    {
        $this->tableName = $tableName;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(?string $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDbFileName(): ?string
    {
        return $this->dbFileName;
    }

    public function setDbFileName(?string $dbFileName): static
    {
        $this->dbFileName = $dbFileName;

        return $this;
    }

    public function getTabId(): ?int
    {
        return $this->tabId;
    }

    public function setTabId(int $tabId): static
    {
        $this->tabId = $tabId;

        return $this;
    }

    public function getRowSize(): ?int
    {
        return $this->rowSize;
    }

    public function setRowSize(int $rowSize): static
    {
        $this->rowSize = $rowSize;

        return $this;
    }

    public function getNumberRows(): ?int
    {
        return $this->numberRows;
    }

    public function setNumberRows(int $numberRows): static
    {
        $this->numberRows = $numberRows;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getTableType(): ?string
    {
        return $this->tableType;
    }

    public function setTableType(?string $tableType): static
    {
        $this->tableType = $tableType;

        return $this;
    }

    public function getAudPath(): ?string
    {
        return $this->audPath;
    }

    public function setAudPath(?string $audPath): static
    {
        $this->audPath = $audPath;

        return $this;
    }

    #[Groups("default")]
    public function getViewSql():string
    {
        $sql_query = "";
        foreach($this->getViews() as $viewElement)
        {
            $sql_query .= $viewElement->getViewText();
        }
        return $sql_query;
    }

    /**
     * @return Collection<int, Column>
     */
    public function getColumns(): Collection
    {
        return $this->columns;
    }

    public function addColumn(Column $column): static
    {
        if (!$this->columns->contains($column)) {
            $this->columns->add($column);
            $column->setTableElement($this);
        }

        return $this;
    }

    public function removeColumn(Column $column): static
    {
        if ($this->columns->removeElement($column)) {
            // set the owning side to null (unless already changed)
            if ($column->getTableElement() === $this) {
                $column->setTableElement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Index>
     */
    public function getIndexes(): Collection
    {
        return $this->indexes;
    }

    public function addIndex(Index $index): static
    {
        if (!$this->indexes->contains($index)) {
            $this->indexes->add($index);
            $index->setTableElement($this);
        }

        return $this;
    }

    public function removeIndex(Index $index): static
    {
        if ($this->indexes->removeElement($index)) {
            // set the owning side to null (unless already changed)
            if ($index->getTableElement() === $this) {
                $index->setTableElement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, View>
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(View $view): static
    {
        if (!$this->views->contains($view)) {
            $this->views->add($view);
            $view->setTableElement($this);
        }

        return $this;
    }

    public function removeView(View $view): static
    {
        if ($this->views->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getTableElement() === $this) {
                $view->setTableElement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DependOn>
     */
    public function getDependencies(): Collection
    {
        return $this->dependencies;
    }

    public function addDependency(DependOn $dependency): static
    {
        if (!$this->dependencies->contains($dependency)) {
            $this->dependencies->add($dependency);
            $dependency->setBTable($this);
        }

        return $this;
    }

    public function removeDependency(DependOn $dependency): static
    {
        if ($this->dependencies->removeElement($dependency)) {
            // set the owning side to null (unless already changed)
            if ($dependency->getBTable() === $this) {
                $dependency->setBTable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DependOn>
     */
    public function getDependOns(): Collection
    {
        return $this->dependOns;
    }

    public function addDependOn(DependOn $dependOn): static
    {
        if (!$this->dependOns->contains($dependOn)) {
            $this->dependOns->add($dependOn);
            $dependOn->setDTable($this);
        }

        return $this;
    }

    public function removeDependOn(DependOn $dependOn): static
    {
        if ($this->dependOns->removeElement($dependOn)) {
            // set the owning side to null (unless already changed)
            if ($dependOn->getDTable() === $this) {
                $dependOn->setDTable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setTableElement($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getTableElement() === $this) {
                $detail->setTableElement(null);
            }
        }

        return $this;
    }
}
