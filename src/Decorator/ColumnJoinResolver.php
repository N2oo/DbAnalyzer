<?php

namespace App\Decorator;

use App\Entity\Table;
use App\Entity\Column;
use ApiPlatform\Metadata\Operation;
use App\Repository\TableRepository;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\Column\ColumnMultipleDTO;
use App\Service\Processor\ColumnMultipleProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(ColumnMultipleProcessor::class)]
class ColumnJoinResolver implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $inner,
        private TableRepository $tableRepository
    ) {
    }

    public function resolveJoins(ColumnMultipleDTO $data)
    {
        $elements = $data->getColumns();
        /** @var Column $element */
        $extractTabIdsCallback = (function ($element) {
            return $element->getTableId();
        });

        $tabIds_list = array_unique(array_map($extractTabIdsCallback, $elements));
        $finded_tables = $this->tableRepository->findByTabIds($tabIds_list);
        if(!empty($finded_tables)){
            $this->hydrateData($elements,$finded_tables);
        }
    }
    /**
     * @param Column[] $columns
     * @param Table[] $findedTables
     */
    public function hydrateData(array $columns,?array $findedTables){
        foreach($findedTables as $table){
            foreach($columns as $column){
                if($column->getTableId() == $table->getTabId()){
                    $table->addColumn($column);
                }
            }
        }
    }

    /**
     * @param ColumnMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->resolveJoins($data);
        return $this->inner->process($data, $operation, $uriVariables, $context);
    }
}