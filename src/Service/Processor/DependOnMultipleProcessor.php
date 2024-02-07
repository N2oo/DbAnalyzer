<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DTO\DependOn\DependOnMultipleDTO;
use App\Entity\DTO\DependOn\DependOnMultipleResponseDTO;

class DependOnMultipleProcessor implements ProcessorInterface
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
            $results->addDependOn($dependOn);
        }
        $this->em->flush();
        return $results;
    }
}