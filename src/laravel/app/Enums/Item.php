<?php

namespace App\Enums;

use App\Contracts\Item as ItemModel;


enum Item: string
{
    case Folders = 'folders';
    case Files = 'files';

    public static function getMorphMap(): array
    {
        return [
            self::Folders->value => 'App\Models\Folder',
            self::Files->value => 'App\Models\File',
        ];
    }
}