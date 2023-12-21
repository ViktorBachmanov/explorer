<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Contracts\Item;
use App\Models\Concerns\Item as ItemTrait;
use App\Models\File;
use App\Http\Resources\Item as ItemResource;


class Folder extends Model implements Item
{
    use HasFactory;
    use ItemTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'parent_id'];

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

    public function getSpecificProps(bool $accessSelfRead): array
    {
        return [
            'folders' => $accessSelfRead 
                ? ItemResource::collection($this->folders->sortBy('name', SORT_NATURAL))
                : [],
            'files' => $accessSelfRead 
                ? ItemResource::collection($this->files->sortBy('name', SORT_NATURAL))
                : [],
        ];

    }
}
