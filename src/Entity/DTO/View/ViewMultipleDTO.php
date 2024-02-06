<?php

namespace App\Entity\DTO\View;

use App\Entity\View as ViewEntity;

final class ViewMultipleDTO
{
    public function __construct(
        protected ?array $Views = null
    )
    {}

    /**
     * @return ?ViewEntity[]
     */
    public function getViews(): ?array
    {
        return $this->Views;
    }
}