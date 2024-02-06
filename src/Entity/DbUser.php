<?php

namespace App\Entity;

use App\Repository\DbUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DbUserRepository::class)]
class DbUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;


    #[ORM\Column(length: 255)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 255)]
    private ?string $groupId = null;

    #[ORM\Column(length: 255)]
    private ?string $homeFolder = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $defaultShell = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): static
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function setGroupId(string $groupId): static
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getHomeFolder(): ?string
    {
        return $this->homeFolder;
    }

    public function setHomeFolder(string $homeFolder): static
    {
        $this->homeFolder = $homeFolder;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDefaultShell(): ?string
    {
        return $this->defaultShell;
    }

    public function setDefaultShell(string $defaultShell): static
    {
        $this->defaultShell = $defaultShell;

        return $this;
    }
}
