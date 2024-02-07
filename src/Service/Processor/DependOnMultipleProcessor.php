<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DTO\DependOn\DependOnMultipleDTO;
use App\Entity\DTO\DependOn\DependOnMultipleResponseDTO;

class DependOnMultipleProcessor implements MultipleEntityProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    /**
     * @param DependOnMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new DependOnMultipleResponseDTO();
        $dependOns = $data->getDependOns();
        if(empty($dependOns)){
            return $results;
        }
        foreach($dependOns as $dependOn){
            $this->em->persist($dependOn);
            $this->em->flush();
            $results->addDependOn($dependOn);
        }
        return $results;
    }
}