<?php

namespace App\Service\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DTO\Column\ColumnMultipleDTO;
use App\Entity\DTO\Column\ColumnMultipleResponseDTO;
use Psr\Log\LoggerInterface;

class ColumnMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private LoggerInterface $logger
    ) {

    }
    /**
     * @param ColumnMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new ColumnMultipleResponseDTO();
        $columns = $data->getColumns();
        if (empty($columns)) {
            return $results;
        }
        foreach ($columns as $column) {
            $this->em->persist($column);
            $results->addColumn($column);
        }
        $this->em->flush();
        return $results;
    }
}