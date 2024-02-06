<?php

namespace App\Entity\DTO\Detail;

use App\Entity\Detail as DetailEntity;

final class DetailMultipleDTO
{
    public function __construct(
        protected ?array $Details = null
    )
    {}

    /**
     * @return ?DetailEntity[]
     */
    public function getDetails(): ?array
    {
        return $this->Details;
    }
}