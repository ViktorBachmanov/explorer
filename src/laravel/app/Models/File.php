<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Concerns\Item as ItemTrait;


class File extends Model
{
    use HasFactory;
    use ItemTrait;

}
