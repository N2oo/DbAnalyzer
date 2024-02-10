<?php

namespace App\Service;

class HtmlConvertor
{
    public static function setInBracket(string $bracket,string $content)
    {
        return "<{$bracket}>{$content}</{$bracket}>";
    }
}