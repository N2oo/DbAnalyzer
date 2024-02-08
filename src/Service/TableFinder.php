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
     */
    private function hydrateTableJoins(array $tables):void
    {
    }

    public function hydrateSingleTable(Table $table):void
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

    /**
     * @param string[] $owner
     */
    public function findByOwners(array $owners)
    {
        return $this->tableRepository->findByOwners($owners);
    }

    public function findByLikelyTableName(string $input)
    {
        return $this->tableRepository->findByLikelyTableName($input);
    }

    public function findByLikelyTableNameAndInOwnerList(array $owners,string $likelyName)
    {
        return $this->tableRepository->findByLikelyTableNameAndInOwnerList($owners,$likelyName);
    }
}