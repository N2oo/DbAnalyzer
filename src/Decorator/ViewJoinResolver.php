<?php

namespace App\Decorator;

use App\Entity\View;
use App\Entity\Table;
use ApiPlatform\Metadata\Operation;
use App\Repository\TableRepository;
use App\Entity\DTO\View\ViewMultipleDTO;
use ApiPlatform\State\ProcessorInterface;
use App\Service\Processor\ViewMultipleProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(ViewMultipleProcessor::class)]
class ViewJoinResolver implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $inner,
        private TableRepository $tableRepository
    ) {
    }

    public function resolveJoins(ViewMultipleDTO $data)
    {
        $elements = $data->getViews();
        /** @var View $element */
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
     * @param View[] $views
     * @param Table[] $findedTables
     */
    public function hydrateData(array $views,?array $findedTables){
        foreach($findedTables as $table){
            foreach($views as $view){
                if($view->getTableId() == $table->getTabId()){
                    $table->addView($view);
                }
            }
        }
    }

    /**
     * @param ViewMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->resolveJoins($data);
        return $this->inner->process($data, $operation, $uriVariables, $context);
    }
}