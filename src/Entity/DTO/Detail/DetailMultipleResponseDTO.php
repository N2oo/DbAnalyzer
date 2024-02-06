<?php

namespace App\Entity\DTO\Detail;

use App\Entity\Detail as DetailEntity;

final class DetailMultipleResponseDTO

{
    public function __construct(
        protected array $details = []
    )
    {}

    public function addDetail(DetailEntity $detail):void
    {
        $this->details[] = $detail;
    }

    /**
     * @return ?DetailEntity[]
     */
    public function getDetails():?array
    {
        return $this->details;
    }
    

}