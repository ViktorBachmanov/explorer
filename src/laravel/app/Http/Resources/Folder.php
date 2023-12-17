<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



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

        $userIdAccessFor = $request->input('userIdAccessFor');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'folders' => self::collection($this->folders),
            'files' => File::collection($this->files),
            'accessForUser' => $this->when(isset($userIdAccessFor), fn () => $this->getAccessForUser($userIdAccessFor)),
        ];
    }
}
