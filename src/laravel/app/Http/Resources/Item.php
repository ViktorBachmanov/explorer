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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'accessSelf' => $this->when($request->user(), fn () => $this->getAccessForUser($request->user()->id)),
            'accessForUser' => $this->when(isset($userIdAccessFor), fn () => $this->getAccessForUser($userIdAccessFor)),
            'folders' => $this->when(($this->resource instanceof Folder), fn () => self::collection($this->folders)),
            'files' => $this->when(($this->resource instanceof Folder), fn () => self::collection($this->files)),
        ];
    }
}
