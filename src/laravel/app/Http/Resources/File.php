<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class File extends JsonResource
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
            'accessForUser' => $this->when(isset($userIdAccessFor), fn () => $this->getAccessForUser($userIdAccessFor)),
        ];
    }
}
