<?php

namespace App\Entity\DTO\Column;

use App\Entity\Column as ColumnEntity;

final class ColumnMultipleResponseDTO

{
    public function __construct(
        protected array $columns = []
    )
    {}

    public function addColumn(ColumnEntity $column):void
    {
        $this->columns[] = $column;
    }

    /**
     * @return ?ColumnEntity[]
     */
    public function getColumns():?array
    {
        return $this->columns;
    }
    

}