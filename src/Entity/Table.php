<?php

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
class Table
{
    public function __toString(): string
    {
        return $this->forDb.'>'.$this->name;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tables')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Database $forDb = null;

    #[ORM\OneToMany(mappedBy: 'forTable', targetEntity: Field::class, orphanRemoval: true)]
    private Collection $fields;

    #[ORM\Column]
    private ?bool $isView = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $query = null;

    #[ORM\Column]
    private ?int $tableOriginalId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentary = null;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getForDb(): ?Database
    {
        return $this->forDb;
    }

    public function setForDb(?Database $forDb): self
    {
        $this->forDb = $forDb;

        return $this;
    }

    /**
     * @return Collection<int, Field>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(Field $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields->add($field);
            $field->setForTable($this);
        }

        return $this;
    }

    public function removeField(Field $field): self
    {
        if ($this->fields->removeElement($field)) {
            // set the owning side to null (unless already changed)
            if ($field->getForTable() === $this) {
                $field->setForTable(null);
            }
        }

        return $this;
    }

    public function isIsView(): ?bool
    {
        return $this->isView;
    }

    public function setIsView(bool $isView): self
    {
        $this->isView = $isView;

        return $this;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(?string $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getTableOriginalId(): ?int
    {
        return $this->tableOriginalId;
    }

    public function setTableOriginalId(int $tableOriginalId): self
    {
        $this->tableOriginalId = $tableOriginalId;

        return $this;
    }

    public function getDumpQuery():string
    {
        $query = "SELECT ";
        foreach ($this->getFields() as $field) {
            $query .= $this->getName().'.'.$field->getName().", ";
        }
        $query = substr($query, 0, -2);
        $query .= " FROM ".$this->getName().";";
        return $query;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): self
    {
        $this->commentary = $commentary;

        return $this;
    }
}
