<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\Detail\DetailMultipleResponseDTO;

class DetailMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new DetailMultipleResponseDTO();
        $details = $data->getDetails();
        if(empty($details)){
            return $results;
        }
        foreach($details as $detail){
            $this->em->persist($detail);
            $this->em->flush();
            $results->addDetail($detail);
        }
        return $results;
    }
}