<?php

namespace App\Service\Finder;

use App\Repository\ColumnRepository;

class ColumnFinder
{
    public function __construct(
        private ColumnRepository $columnRepository
    )
    {}

    public function findByTableAndColumnNo(array $datas)
    {
        $columns = [];
        foreach($datas as $data){
            $table = $data["table"];
            $parts = $data["columns"];
            $results = $this->columnRepository->findByTableAndColumnNo($table,$parts);
            $columns = array_merge($results,$columns);
        }
        return $columns;
    }
}