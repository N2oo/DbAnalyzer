<?php

namespace App\Service;

use App\Entity\Table;
use App\Repository\TableRepository;

class TableFinder
{

    public function __construct(
        private readonly TableRepository $tableRepository
    )
    {

    }

    /**
     * @return Table[]
     */
    public function findAllTables():array
    {
        return $this->tableRepository->findAll();
    }

    /**
     * @param Table[] $tables
     * @return Table[]
     */
    private function hydrateTableJoins(array $tables)
    {

    }

    public function hydrateSingleTable(Table $table)
    {
        $this->hydrateTableJoins([$table]);
    }

    /**
     * @return Table[]
     */
    public function findAllTablesAndHydrateJoins():array
    {
        $all_tables = $this->findAllTables();
        $this->hydrateTableJoins($all_tables);
        return $all_tables;
    }
}