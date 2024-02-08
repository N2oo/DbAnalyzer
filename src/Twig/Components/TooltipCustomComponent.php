<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class TooltipCustomComponent
{
    public string $title="modifier title";
    public string $placement= "top";
    public string $class ="";
    public bool $html=false;
    public string $trigger="hover focus";
    public ?string $href = null;
}
