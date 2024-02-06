<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use Doctrine\Common\Collections\Collection;
use App\Entity\DTO\Detail\DetailMultipleDTO;
use Doctrine\Common\Collections\ArrayCollection;
use App\Service\Processor\DetailMultipleProcessor;
use App\Entity\DTO\Detail\DetailMultipleResponseDTO;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[
    ORM\Entity(repositoryClass: DetailRepository::class),
    ApiResource(
        shortName: "Détail",
        description: "Détails sur la table",
        uriTemplate: "detail",
        operations: [
            new Get(uriTemplate: "detail/{id}"),
            new GetCollection(),
            new Post(),
            new Post(
                uriTemplate:'detail/multiple',
                openapi: new Operation(
                    summary:"Envoi de multiple instances de detail",
                    description: "Utiliez ce endpoint pour envoyer plusieurs details à la fois"
                ),
                input: DetailMultipleDTO::class,
                output: DetailMultipleResponseDTO::class,
                processor: DetailMultipleProcessor::class
            )
        ]
    )
]
class Detail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    
    #[SerializedName('inode')]
    private ?int $iNode = null;

    #[ORM\Column(length: 255)]
    private ?string $permissions = null;

    #[ORM\Column]
    
    #[SerializedName('cntlink')]
    private ?int $countLink = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('file_owner')]
    private ?string $fileOwner = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('filegroup')]
    private ?string $fileGroup = null;

    #[ORM\Column(type: Types::BIGINT)]
    
    #[SerializedName('filesize')]
    private ?string $fileSize = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('file_location')]
    private ?string $fileLocation = null;

    #[ORM\Column(length: 255)]
    private ?string $folder = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('filename')]
    private ?string $fileName = null;

    #[ORM\Column(length: 255)]
    
    #[SerializedName('file_extension')]
    private ?string $fileExtension = null;

    #[ORM\ManyToMany(targetEntity: DbUser::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getINode(): ?int
    {
        return $this->iNode;
    }

    public function setINode(int $iNode): static
    {
        $this->iNode = $iNode;

        return $this;
    }

    public function getPermissions(): ?string
    {
        return $this->permissions;
    }

    public function setPermissions(string $permissions): static
    {
        $this->permissions = $permissions;

        return $this;
    }

    public function getCountLink(): ?int
    {
        return $this->countLink;
    }

    public function setCountLink(int $countLink): static
    {
        $this->countLink = $countLink;

        return $this;
    }

    public function getFileOwner(): ?string
    {
        return $this->fileOwner;
    }

    public function setFileOwner(string $fileOwner): static
    {
        $this->fileOwner = $fileOwner;

        return $this;
    }

    public function getFileGroup(): ?string
    {
        return $this->fileGroup;
    }

    public function setFileGroup(string $fileGroup): static
    {
        $this->fileGroup = $fileGroup;

        return $this;
    }

    public function getFileSize(): ?string
    {
        return $this->fileSize;
    }

    public function setFileSize(string $fileSize): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getFileLocation(): ?string
    {
        return $this->fileLocation;
    }

    public function setFileLocation(string $fileLocation): static
    {
        $this->fileLocation = $fileLocation;

        return $this;
    }

    public function getFolder(): ?string
    {
        return $this->folder;
    }

    public function setFolder(string $folder): static
    {
        $this->folder = $folder;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->fileName;
    }

    public function setFilename(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileExtension(): ?string
    {
        return $this->fileExtension;
    }

    public function setFileExtension(string $fileExtension): static
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * @return Collection<int, DbUser>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(DbUser $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(DbUser $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }
}
