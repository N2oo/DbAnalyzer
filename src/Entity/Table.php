<?php

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
#[ApiResource(
    uriTemplate: "table",
    operations:[
        new Get(uriTemplate:"table/{id}"),
        new GetCollection(),
        new Post()
    ])
]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tableName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dbFileName = null;

    #[ORM\Column]
    private ?int $tabId = null;

    #[ORM\Column]
    private ?int $rowSize = null;

    #[ORM\Column]
    private ?int $numberRows = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $version = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tableType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $audPath = null;

    #[ORM\OneToMany(mappedBy: 'tableElement', targetEntity: Column::class)]
    private Collection $columns;

    #[ORM\OneToMany(mappedBy: 'tableElement', targetEntity: Index::class)]
    private Collection $indexes;

    #[ORM\OneToMany(mappedBy: 'tableElement', targetEntity: View::class)]
    private Collection $views;

    #[ORM\OneToMany(mappedBy: 'bTable', targetEntity: DependOn::class)]
    private Collection $dependencies;

    #[ORM\OneToMany(mappedBy: 'dTable', targetEntity: DependOn::class)]
    private Collection $dependOns;

    public function __construct()
    {
        $this->columns = new ArrayCollection();
        $this->indexes = new ArrayCollection();
        $this->views = new ArrayCollection();
        $this->dependencies = new ArrayCollection();
        $this->dependOns = new ArrayCollection();
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

    public function getViewSql():string
    {
        return "";
        //TODO : implémenter la méthode pour générer la requête SQL
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
}
