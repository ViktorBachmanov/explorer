<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Folder;


class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userIdAccessFor = $request->input('userIdAccessFor');

        $user = $request->user();
        $accessSelf = $user
            ? $this->getAccessForUser($request->user()->id)
            : $this->getAccesForGuest();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'accessSelf' => $accessSelf,
            'accessForUser' => $this->when(isset($userIdAccessFor) && $userIdAccessFor != -1, fn () => $this->getAccessForUser($userIdAccessFor)),
            'folders' => $this->when(($this->resource instanceof Folder), fn () => self::collection($this->folders)),
            'files' => $this->when(($this->resource instanceof Folder), fn () => self::collection($this->files)),
        ];
    }
}
