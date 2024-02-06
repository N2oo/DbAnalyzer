<?php

namespace App\Entity\DTO\Index;

use App\Entity\Index as IndexEntity;

final class IndexMultipleResponseDTO

{
    public function __construct(
        protected array $indexs = []
    )
    {}

    public function addIndex(IndexEntity $index):void
    {
        $this->indexs[] = $index;
    }

    /**
     * @return ?IndexEntity[]
     */
    public function getIndexs():?array
    {
        return $this->indexs;
    }
    

}