<?php

namespace App\Strategy\SearchTable;

use App\Service\TableFinder;
use App\Entity\ValueObject\SearchTableQuery;

class SearchTableByOwnerAndInput implements SearchTableStrategy
{
    public function __construct(
        private TableFinder $tableFinder,
        private SearchTableQuery $searchTableQuery
    )
    {

    }
    public function find():array{
        $owners = $this->searchTableQuery->getOwners();
        $input = $this->searchTableQuery->getUserQuery();
        return $this->tableFinder->findByLikelyTableNameAndInOwnerList($owners,$input,true);
    }
}