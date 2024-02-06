<?php

namespace App\Entity\DTO\Table;

use App\Entity\Table as TableEntity;

final class TableMultipleDTO
{
    public function __construct(
        protected ?array $tables = null
    )
    {}

    /**
     * @return ?TableEntity[]
     */
    public function getTables(): ?array
    {
        return $this->tables;
    }
}