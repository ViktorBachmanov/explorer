<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Contracts\Item;
use App\Models\Concerns\Item as ItemTrait;
use App\Models\Folder;


class File extends Model implements Item
{
    use HasFactory;
    use ItemTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'text', 'folder_id'];

    /**
     * Get the folder that owns the file
     */
    public function parentFolder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function getSpecificProps(bool $accessSelfRead): array
    {
        return [
            'text' => $accessSelfRead 
                ? $this->text
                : null,
        ];
        
    }

}
