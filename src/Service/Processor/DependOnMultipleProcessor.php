<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\DependOn\DependOnMultipleResponseDTO;

class DependOnMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
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