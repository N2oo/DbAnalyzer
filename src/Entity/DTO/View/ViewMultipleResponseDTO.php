<?php

namespace App\Entity\DTO\View;

use App\Entity\View as ViewEntity;

final class ViewMultipleResponseDTO

{
    public function __construct(
        protected array $views = []
    )
    {}

    public function addView(ViewEntity $view):void
    {
        $this->views[] = $view;
    }

    /**
     * @return ?ViewEntity[]
     */
    public function getViews():?array
    {
        return $this->views;
    }
    

}