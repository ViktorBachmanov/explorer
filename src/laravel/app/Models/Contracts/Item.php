<?php

namespace App\Models\Contracts;


interface Item
{
    public function getAccesForGuest(): array;   
    
    public function getAccessForUser(int $userId): array;   

    public function getSpecificProps(bool $accessSelfRead): array;    
}