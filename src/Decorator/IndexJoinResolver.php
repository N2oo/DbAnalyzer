<?php

namespace App\Decorator;

use App\Entity\Index;
use App\Entity\Table;
use ApiPlatform\Metadata\Operation;
use App\Repository\TableRepository;
use App\Service\Finder\ColumnFinder;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Column;
use App\Entity\DTO\Index\IndexMultipleDTO;
use App\Service\Processor\IndexMultipleProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(IndexMultipleProcessor::class)]
class IndexJoinResolver implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $inner,
        private TableRepository $tableRepository,
        private readonly ColumnFinder $columnFinder
    ) {
    }

    
    private function resolveTableJoins(IndexMultipleDTO $data)
    {
        $elements = $data->getIndexs();
        /** @var Index $element */
        $extractTabIdsCallback = (function ($element) {
            return $element->getTableId();
        });

        $tabIds_list = array_unique(array_map($extractTabIdsCallback, $elements));
        $finded_tables = $this->tableRepository->findByTabIds($tabIds_list);
        if(!empty($finded_tables)){
            $this->hydrateTableData($elements,$finded_tables);
        }
    }

    private function resolveColumnJoins(IndexMultipleDTO $data)
    {
        $elements = $data->getIndexs();
        /** @var Index $element */
        $extractTableAndColumnNoCallback = (function (Index $element){
            $table = $element->getTableElement();
            $colNo1 = $element->getPart1();
            $colNo2 = $element->getPart2();
            $colNo3 = $element->getPart3();
            $colNo4 = $element->getPart4();
            $colNo5 = $element->getPart5();
            $colNo6 = $element->getPart6();
            $colNo7 = $element->getPart7();
            $colNo8 = $element->getPart8();
            $returned_value = [
                "table"=>$table,
                "columns"=>[$colNo1,$colNo2,$colNo3,$colNo4,$colNo5,$colNo6,$colNo7,$colNo8]
            ];
            return $returned_value;
        });

        $tableAndColumns = array_map($extractTableAndColumnNoCallback,$elements);
        $findedColumns = $this->columnFinder->findByTableAndColumnNo($tableAndColumns);
        if(!empty($findedColumns))
        {
            $this->hydrateColumnData($elements,$findedColumns);
        }

    }

    private function addColumnToIndexIfResolved(Column $column,Index $index)
    {
        if ($index->getTableElement() === $column->getTableElement())
        {
            ($index->getPart1() != 0 && $index->getPart1() == $column->getColumnNumber()) ? $index->setColumn1($column):null;
            ($index->getPart2() != 0 && $index->getPart2() == $column->getColumnNumber()) ? $index->setColumn2($column):null;
            ($index->getPart3() != 0 && $index->getPart3() == $column->getColumnNumber()) ? $index->setColumn3($column):null;
            ($index->getPart4() != 0 && $index->getPart4() == $column->getColumnNumber()) ? $index->setColumn4($column):null;
            ($index->getPart5() != 0 && $index->getPart5() == $column->getColumnNumber()) ? $index->setColumn5($column):null;
            ($index->getPart6() != 0 && $index->getPart6() == $column->getColumnNumber()) ? $index->setColumn6($column):null;
            ($index->getPart7() != 0 && $index->getPart7() == $column->getColumnNumber()) ? $index->setColumn7($column):null;
            ($index->getPart8() != 0 && $index->getPart8() == $column->getColumnNumber()) ? $index->setColumn8($column):null;
        }
    }
    
    private function hydrateColumnData(array $indexes, ?array $findedColumns)
    {
        foreach($findedColumns as $column){
            foreach($indexes as $index){
                $this->addColumnToIndexIfResolved($column,$index);
            }
        }
    }
    
    /**
     * @param Index[] $indexes
     * @param Table[] $findedTables
     */
    private function hydrateTableData(array $indexes,?array $findedTables){
        foreach($findedTables as $table){
            foreach($indexes as $index){
                if($index->getTableId() == $table->getTabId()){
                    $table->addIndex($index);
                }
            }
        }
    }

    private function resolveJoins(IndexMultipleDTO $data)
    {
        $this->resolveTableJoins($data);
        $this->resolveColumnJoins($data);
    }
    /**
     * @param IndexMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->resolveJoins($data);
        return $this->inner->process($data, $operation, $uriVariables, $context);
    }
}