<?php

namespace App\Strategy\SearchTable;

use App\Service\TableFinder;
use App\Entity\ValueObject\SearchTableQuery;

class SearchTableByInput implements SearchTableStrategy
{
    public function __construct(
        private TableFinder $tableFinder,
        private SearchTableQuery $searchTableQuery
    )
    {}
    
    public function find():array{
        $input = $this->searchTableQuery->getUserQuery();
        return $this->tableFinder->findByLikelyTableName($input,true);
    }
}