<?php

namespace App\Entity\DTO\Column;

use App\Entity\Column as ColumnEntity;

final class ColumnMultipleDTO
{
    public function __construct(
        protected ?array $columns = null
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