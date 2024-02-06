<?php

namespace App\Entity\DTO\Index;

use App\Entity\Index as IndexEntity;

final class IndexMultipleDTO
{
    public function __construct(
        protected ?array $indexs = null
    )
    {}

    /**
     * @return ?IndexEntity[]
     */
    public function getIndexs(): ?array
    {
        return $this->indexs;
    }
}