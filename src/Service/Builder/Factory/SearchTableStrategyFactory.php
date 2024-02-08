<?php

namespace App\Service\Builder\Factory;

use App\Service\TableFinder;
use App\Entity\ValueObject\SearchTableQuery;
use App\Strategy\SearchTable\SearchTableByInput;
use App\Strategy\SearchTable\SearchTableDefault;
use App\Strategy\SearchTable\SearchTableByOwners;
use App\Strategy\SearchTable\SearchTableStrategy;
use App\Strategy\SearchTable\SearchTableByOwnerAndInput;

class SearchTableStrategyFactory
{
    public function __construct(
        private TableFinder $tableFinder
    )
    {}

    private function resolveStrategy(SearchTableQuery $searchTableQuery):SearchTableStrategy
    {
        $input = $searchTableQuery->getUserQuery();
        $owners =$searchTableQuery->getOwners();
        $isInputFilled = isset($input) && $input != "";
        $isOwnerFilled = !empty($owners);
        return match(true){
            ($isInputFilled && $isOwnerFilled)=>new SearchTableByOwnerAndInput($this->tableFinder,$searchTableQuery),
            $isInputFilled=>new SearchTableByInput($this->tableFinder,$searchTableQuery),
            $isOwnerFilled=>new SearchTableByOwners($this->tableFinder,$searchTableQuery),
            default=>new SearchTableDefault($this->tableFinder)
        };
    }

    public function getStrategy(SearchTableQuery $searchTableQuery):SearchTableStrategy
    {
        $strategy = $this->resolveStrategy($searchTableQuery);
        return $strategy;
    }
}