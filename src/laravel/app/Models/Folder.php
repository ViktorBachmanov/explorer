<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Contracts\Item;
use App\Models\Concerns\Item as ItemTrait;
use App\Models\File;


class Folder extends Model implements Item
{
    use HasFactory;
    use ItemTrait;

    /**
     * Get the children folders
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    /**
     * Get the children files
     */
    public function files(): HasMany
    {
        return $this->hasMany(FIle::class);
    }
}
