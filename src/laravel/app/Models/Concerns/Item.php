<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\UniqueConstraintViolationException;

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

    public function updateAccess(int $userIdAccessFor, AccessEnum $accessType, bool $accessValue): void
    {
        $affectedRows = $this->users()->updateExistingPivot($userIdAccessFor, [
            $accessType->value => $accessValue,
        ]);
      
        if ($affectedRows == 0) {
            $this->createAccess($userIdAccessFor, $accessType, $accessValue);
        }
    }

    public function getAccessesForUser(int $userId): array
    {
        if (User::find($userId)->is_admin) {
            foreach (AccessEnum::cases() as $case) {
                $accesses[$case->value] = true;
            }
            return $accesses;
        }

        $user = $this->users()->firstWhere('users.id', $userId);

        foreach (AccessEnum::cases() as $case) {
            $accesses[$case->value] = $user
                ? (bool) $user->pivot->{$case->value}
                : false;
        }

        return $accesses;
    }

    public function getAccessesForGuest(): array 
    {
        foreach (AccessEnum::cases() as $case) {
            $accesses[$case->value] = false;
        }
        return $accesses;
    }

    public static function createItem(string $name, int $parentFolderId)
    {
        $parentField = match (__CLASS__) {
            'App\Models\Folder' => 'parent_id',
            'App\Models\File' => 'folder_id',
        };
        
        $item = self::create([
            'name' => $name,
            $parentField => $parentFolderId,
        ]);

        $accesses = [];

        foreach (AccessEnum::cases() as $case) {
            $accesses[$case->value] = true;
        }

        $item->users()->attach(Auth::id(), $accesses);
    }
    
    public function rename(string $newName): void
    {
        try {
            $this->update(['name' => $newName]);
        } catch (UniqueConstraintViolationException) {
            abort(409, 'Item with this name already exists in the folder');
        }
    }

    private function createAccess(int $userId, AccessEnum $accessType, bool $accessValue): void
    {
        $this->users()->attach($userId, [$accessType->value => $accessValue]);
    }
}