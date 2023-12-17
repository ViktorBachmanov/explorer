<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

use App\Models\User;
use App\Enums\Access as AccessEnum;

trait Item
{
    /**
     * Get all of the users for the item.
     */
    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'userable')
            ->withTimestamps()
            ->withPivot('read', 'write', 'grant');
    }

    public function createAccess(int $userId, AccessEnum $accessType, bool $accessValue): void
    {
        $this->users()->attach($userId, [$accessType->value => $accessValue]);
    }
}