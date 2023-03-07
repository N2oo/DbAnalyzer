<?php

namespace App\Entity;

use App\Repository\FieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity(repositoryClass: FieldRepository::class)]
class Field
{
    public function __toString(): string
    {
        return $this->forTable.'>'.$this->name;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'fields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Table $forTable = null;

    #[ORM\Column(nullable: true)]
    private ?int $type = null;

    #[ORM\Column]
    private ?int $length = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'usages')]
    private ?self $useProperty = null;

    #[ORM\OneToMany(mappedBy: 'useProperty', targetEntity: self::class)]
    private Collection $usages;

    #[ORM\Column]
    private ?bool $isPrimary = null;

    public function __construct()
    {
        $this->usages = new ArrayCollection();
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

    public function getForTable(): ?Table
    {
        return $this->forTable;
    }

    public function setForTable(?Table $forTable): self
    {
        $this->forTable = $forTable;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getUseProperty(): ?self
    {
        return $this->useProperty;
    }

    public function setUseProperty(?self $useProperty): self
    {
        $this->useProperty = $useProperty;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUsages(): Collection
    {
        return $this->usages;
    }

    public function addUsage(self $usage): self
    {
        if (!$this->usages->contains($usage)) {
            $this->usages->add($usage);
            $usage->setUseProperty($this);
        }

        return $this;
    }

    public function removeUsage(self $usage): self
    {
        if ($this->usages->removeElement($usage)) {
            // set the owning side to null (unless already changed)
            if ($usage->getUseProperty() === $this) {
                $usage->setUseProperty(null);
            }
        }

        return $this;
    }

    public function isIsPrimary(): ?bool
    {
        return $this->isPrimary;
    }

    public function setIsPrimary(bool $isPrimary): self
    {
        $this->isPrimary = $isPrimary;

        return $this;
    }
}
