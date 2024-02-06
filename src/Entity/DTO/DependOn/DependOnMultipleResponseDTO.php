<?php

namespace App\Entity\DTO\DependOn;

use App\Entity\DependOn as DependOnEntity;

final class DependOnMultipleResponseDTO

{
    public function __construct(
        protected array $DependOns = []
    )
    {}

    public function addDependOn(DependOnEntity $DependOn):void
    {
        $this->DependOns[] = $DependOn;
    }

    /**
     * @return ?DependOnEntity[]
     */
    public function getDependOns():?array
    {
        return $this->DependOns;
    }
    

}