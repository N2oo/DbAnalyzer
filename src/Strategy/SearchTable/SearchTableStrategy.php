<?php

namespace App\Strategy\SearchTable;

interface SearchTableStrategy
{
    public function find():array;
}