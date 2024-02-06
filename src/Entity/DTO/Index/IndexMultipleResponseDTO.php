<?php

namespace App\Entity\DTO\Index;

use App\Entity\Index as IndexEntity;

final class IndexMultipleResponseDTO

{
    public function __construct(
        protected array $Indexs = []
    )
    {}

    public function addIndex(IndexEntity $Index):void
    {
        $this->Indexs[] = $Index;
    }

    /**
     * @return ?IndexEntity[]
     */
    public function getIndexs():?array
    {
        return $this->Indexs;
    }
    

}