<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
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
            $results->addTable($table);
        }
        $this->em->flush();
        return $results;
    }
}