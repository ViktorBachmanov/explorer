<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// use App\Enums\Item as ItemEnum;


class Folder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            // 'type' => ItemEnum::Folders->value,
            'name' => $this->name,
            'folders' => self::collection($this->folders),
            'files' => File::collection($this->files),
        ];
    }
}
