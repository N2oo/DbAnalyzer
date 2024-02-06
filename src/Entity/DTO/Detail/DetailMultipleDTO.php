<?php

namespace App\Entity\DTO\Detail;

use App\Entity\Detail as DetailEntity;

final class DetailMultipleDTO
{
    public function __construct(
        protected ?array $details = null
    )
    {}

    /**
     * @return ?DetailEntity[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }
}