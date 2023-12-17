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
            ->withPivot(AccessEnum::Read->value, AccessEnum::Write->value, AccessEnum::Grant->value);
    }

    public function createAccess(int $userId, AccessEnum $accessType, bool $accessValue): void
    {
        $this->users()->attach($userId, [$accessType->value => $accessValue]);
    }

    public function getAccessForUser(int $userId): array
    {
        $user = $this->users()->firstWhere('users.id', $userId);
        // $pivot = $this->users()->one()->ofMany('id', $userId)->pivot;

        foreach (AccessEnum::cases() as $case) {
            $accesses[$case->value] = $user
                ? (bool) $user->pivot->{$case->value}
                : false;
        }

        return $accesses;
    }
}