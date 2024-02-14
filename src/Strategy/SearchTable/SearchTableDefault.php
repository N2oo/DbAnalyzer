<?php

namespace App\Strategy\SearchTable;

use App\Service\TableFinder;

class SearchTableDefault implements SearchTableStrategy
{
    public function __construct(
        private TableFinder $tableFinder
        )
    {

    }
    public function find():array{
        return $this->tableFinder->findAllTables(true);
    }
}