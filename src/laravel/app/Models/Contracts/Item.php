<?php

namespace App\Models\Contracts;


interface Item
{
    public function getAccessesForGuest(): array;   
    
    public function getAccessesForUser(int $userId): array;   

    public function getSpecificProps(bool $accessSelfRead): array;    
}