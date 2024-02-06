<?php

namespace App\Entity\DTO\Detail;

use App\Entity\Detail as DetailEntity;

final class DetailMultipleResponseDTO

{
    public function __construct(
        protected array $Details = []
    )
    {}

    public function addDetail(DetailEntity $Detail):void
    {
        $this->Details[] = $Detail;
    }

    /**
     * @return ?DetailEntity[]
     */
    public function getDetails():?array
    {
        return $this->Details;
    }
    

}