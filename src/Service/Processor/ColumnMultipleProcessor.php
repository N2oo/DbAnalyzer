<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\Column\ColumnMultipleResponseDTO;

class ColumnMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new ColumnMultipleResponseDTO();
        $columns = $data->getColumns();
        if(empty($columns)){
            return $results;
        }
        foreach($columns as $column){
            $this->em->persist($column);
            $this->em->flush();
            $results->addColumn($column);
        }
        return $results;
    }
}