<?php

namespace App\Entity\DTO\DependOn;

use App\Entity\DependOn as DependOnEntity;

final class DependOnMultipleResponseDTO

{
    public function __construct(
        protected array $dependOns = []
    )
    {}

    public function addDependOn(DependOnEntity $dependOn):void
    {
        $this->dependOns[] = $dependOn;
    }

    /**
     * @return ?DependOnEntity[]
     */
    public function getDependOns():?array
    {
        return $this->dependOns;
    }
    

}