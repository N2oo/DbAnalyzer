<?php

namespace App\Entity\DTO\Column;

use App\Entity\Column as ColumnEntity;

final class ColumnMultipleDTO
{
    public function __construct(
        private ?array $columns = null
    )
    {}

    /**
     * @return ?ColumnEntity[]
     */
    public function getColumns(): ?array
    {
        return $this->columns;
    }
}