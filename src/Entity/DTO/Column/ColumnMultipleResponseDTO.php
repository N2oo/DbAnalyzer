<?php

namespace App\Entity\DTO\Column;

use App\Entity\Column as ColumnEntity;

final class ColumnMultipleResponseDTO

{
    public function __construct(
        protected array $Columns = []
    )
    {}

    public function addColumn(ColumnEntity $Column):void
    {
        $this->Columns[] = $Column;
    }

    /**
     * @return ?ColumnEntity[]
     */
    public function getColumns():?array
    {
        return $this->Columns;
    }
    

}