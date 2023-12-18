<?php

namespace App\Models\Contracts;


interface Item
{
    public function getAccesForGuest(): array;    
}