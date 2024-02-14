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
    public function findAllTables(bool $shouldHydrate = false):array
    {
        $all_tables =$this->tableRepository->findAll();
        if($shouldHydrate)
        {
            $this->hydrateTableJoins($all_tables);
        }
        return $all_tables;
    }

    /**
     * @param Table[] $tables
     */
    private function hydrateTableJoins(array $tables):void
    {
        $this->tableRepository->hydrateTables($tables);
    }

    public function hydrateSingleTable(Table $table):void
    {
        $this->hydrateTableJoins([$table]);
    }

    /**
     * @param string[] $owner
     */
    public function findByOwners(array $owners, bool $shouldHydrate=false)
    {
        $all_tables = $this->tableRepository->findByOwners($owners);
        if($shouldHydrate){
            $this->hydrateTableJoins($all_tables);
        }
        return $all_tables;
    }

    public function findByLikelyTableName(string $input, bool $shouldHydrate=false)
    {
        $all_tables = $this->tableRepository->findByLikelyTableName($input);
        if($shouldHydrate){
            $this->hydrateTableJoins($all_tables);
        }
        return $all_tables;
    }

    public function findByLikelyTableNameAndInOwnerList(array $owners,string $likelyName, bool $shouldHydrate=false)
    {
        $all_tables = $this->tableRepository->findByLikelyTableNameAndInOwnerList($owners,$likelyName);
        if($shouldHydrate){
            $this->hydrateTableJoins($all_tables);
        }
        return $all_tables;
    }
}