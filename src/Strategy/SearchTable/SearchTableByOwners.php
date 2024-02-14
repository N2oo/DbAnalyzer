<?php

namespace App\Strategy\SearchTable;

use App\Entity\ValueObject\SearchTableQuery;
use App\Service\TableFinder;

class SearchTableByOwners implements SearchTableStrategy
{
    public function __construct(
        private TableFinder $tableFinder,
        private SearchTableQuery $searchTableQuery
    )
    {

    }
    public function find():array{
        $owners = $this->searchTableQuery->getOwners();
        return $this->tableFinder->findByOwners($owners,true);
    }
}