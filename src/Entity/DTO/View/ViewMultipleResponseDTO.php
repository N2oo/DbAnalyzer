<?php

namespace App\Entity\DTO\View;

use App\Entity\View as ViewEntity;

final class ViewMultipleResponseDTO

{
    public function __construct(
        protected array $Views = []
    )
    {}

    public function addView(ViewEntity $View):void
    {
        $this->Views[] = $View;
    }

    /**
     * @return ?ViewEntity[]
     */
    public function getViews():?array
    {
        return $this->Views;
    }
    

}