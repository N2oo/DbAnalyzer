<?php

namespace App\Entity\DTO\Column;

use App\Entity\Column as ColumnEntity;

final class ColumnMultipleDTO
{
    public function __construct(
        protected ?array $Columns = null
    )
    {}

    /**
     * @return ?ColumnEntity[]
     */
    public function getColumns(): ?array
    {
        return $this->Columns;
    }
}