<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

use App\Enums\Access;


class Userable extends MorphPivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'userables';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        Access::Read->value => 'boolean',
        Access::Write->value => 'boolean',
        Access::Grant->value => 'boolean',
    ];
}
