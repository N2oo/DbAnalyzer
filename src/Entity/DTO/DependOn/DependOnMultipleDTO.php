<?php

namespace App\Entity\DTO\DependOn;

use App\Entity\DependOn as DependOnEntity;

final class DependOnMultipleDTO
{
    public function __construct(
        protected ?array $DependOns = null
    )
    {}

    /**
     * @return ?DependOnEntity[]
     */
    public function getDependOns(): ?array
    {
        return $this->DependOns;
    }
}