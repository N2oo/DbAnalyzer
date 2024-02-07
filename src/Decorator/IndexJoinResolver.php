<?php

namespace App\Decorator;

use App\Entity\Table;
use App\Entity\Index;
use ApiPlatform\Metadata\Operation;
use App\Repository\TableRepository;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\Index\IndexMultipleDTO;
use App\Service\Processor\IndexMultipleProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(IndexMultipleProcessor::class)]
class IndexJoinResolver implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $inner,
        private TableRepository $tableRepository
    ) {
    }

    public function resolveJoins(IndexMultipleDTO $data)
    {
        $elements = $data->getIndexs();
        /** @var Index $element */
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
     * @param Index[] $indexes
     * @param Table[] $findedTables
     */
    public function hydrateData(array $indexes,?array $findedTables){
        foreach($findedTables as $table){
            foreach($indexes as $index){
                if($index->getTableId() == $table->getTabId()){
                    $table->addIndex($index);
                }
            }
        }
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