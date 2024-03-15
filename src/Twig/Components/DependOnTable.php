<?php

namespace App\Twig\Components;

use App\Entity\DependOn;
use App\Entity\Table;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class DependOnTable
{
    const BTABLE = "btable";
    const DTABLE = "dtable";

    public string $property= self::DTABLE;
    public Table $table;

    public function getDependOns()
    {
        if($this->property == self::BTABLE)
        {
            return $this->table->getDependOns();
        }
        return $this->table->getDependencies();
    }
    
    /**
     * @param DependOn
     */
    public function getTable(DependOn $dependOn)
    {
        if($this->property == self::BTABLE)
        {
            return $dependOn->getBTable();
        }
        return $dependOn->getDTable();
    }
}
