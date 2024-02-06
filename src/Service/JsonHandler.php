<?php

namespace App\Service;

use App\Entity\DTO\TableDTO;
use Symfony\Component\Serializer\SerializerInterface;

class JsonHandler
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {}

    public function handleJsonContent(string $jsonContent)
    {
        return $this->serializer->deserialize($jsonContent,"App\Entity\DTO\TableDTO[]","json");
    }
    public function handleFile(string $jsonFilePath)
    {
        $jsonContent = file_get_contents($jsonFilePath);
        return $this->handleJsonContent($jsonContent);
        
    }
}