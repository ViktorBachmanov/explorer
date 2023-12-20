<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Contracts\Item;
use App\Models\Concerns\Item as ItemTrait;


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

    public function getSpecificProps(bool $accessSelfRead): array
    {
        return [
            'text' => $accessSelfRead 
                ? $this->text
                : null,
        ];
        
    }

}
