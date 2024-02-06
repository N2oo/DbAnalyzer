<?php

namespace App\Entity\DTO\Table;

use App\Entity\Table as TableEntity;

class TableMultipleResponseDTO

{

    public function __construct(
        protected array $tables = []
    )
    {}

    public function addTable(TableEntity $table):void
    {
        $this->tables[] = $table;
    }

    /**
     * @return ?TableEntity[]
     */
    public function getTables():?array
    {
        return $this->tables;
    }
    

}