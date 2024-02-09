<?php

namespace App\Twig\Components;

use App\Entity\DbUser;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class TableUserComponent
{
    public ?string $definedFilter=null;
    /**
     * @var DbUser[] $users
     */
    public array $users=[];

    public ?string $caption = null;
}
