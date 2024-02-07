<?php
 namespace App\Decorator;
 use ApiPlatform\State\ProcessorInterface;
use App\Entity\Table;
use App\Entity\DependOn;
use ApiPlatform\Metadata\Operation;
use App\Repository\TableRepository;
use App\Entity\DTO\DependOn\DependOnMultipleDTO;
use App\Service\Processor\DependOnMultipleProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

 #[AsDecorator(DependOnMultipleProcessor::class)]
 class DependOnJoinResolver implements ProcessorInterface
 {
    public function __construct(
        private ProcessorInterface $inner,
        private TableRepository $tableRepository
    ) {
    }

    public function resolveJoins(DependOnMultipleDTO $data)
    {
        $elements = $data->getDependOns();
        /** @var DependOn $element */
        $extractTabIdsCallback1 = (function ($element) {
            return $element->getBTableIdOriginal();
        });
        /** @var DependOn $element */
        $extractTabIdsCallback2 = (function ($element) {
            return $element->getDTableIdOriginal();
        });

        $tabIds_list1 = array_unique(array_map($extractTabIdsCallback1, $elements));
        $tabIds_list2 = array_unique(array_map($extractTabIdsCallback2, $elements));
        $tabIds_list = array_unique(array_merge($tabIds_list1,$tabIds_list2));
        
        $finded_tables = $this->tableRepository->findByTabIds($tabIds_list);
        if(!empty($finded_tables)){
            $this->hydrateData($elements,$finded_tables);
        }
    }
    /**
     * @param DependOn[] $dependOns
     * @param Table[] $findedTables
     */
    public function hydrateData(array $dependOns,?array $findedTables){
        foreach($findedTables as $table){
            foreach($dependOns as $dependOn){
                if($dependOn->getBTableIdOriginal() == $table->getTabId()){
                    $table->addDependency($dependOn);
                }
                if($dependOn->getDTableIdOriginal() == $table->getTabId()){
                    $table->addDependOn($dependOn);
                }
            }
        }
    }

    /**
     * @param DependOnMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->resolveJoins($data);
        return $this->inner->process($data, $operation, $uriVariables, $context);
    }
 }