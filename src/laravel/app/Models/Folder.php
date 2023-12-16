<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Contracts\Item;


class Folder extends Model implements Item
{
    use HasFactory;
}
