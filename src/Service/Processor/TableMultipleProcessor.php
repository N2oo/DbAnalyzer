<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\Table\TableMultipleDTO;
use App\Entity\DTO\Table\TableMultipleResponseDTO;

class TableMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    /**
     * @param TableMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new TableMultipleResponseDTO();
        $tables = $data->getTables();
        if(empty($tables)){
            return $results;
        }
        foreach($tables as $table){
            $this->em->persist($table);
            $this->em->flush();
            $results->addTable($table);
        }
        return $results;
    }
}