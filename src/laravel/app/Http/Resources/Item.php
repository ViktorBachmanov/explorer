<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Folder;
use App\Enums\Access;


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

        $commonProps = [
            'id' => $this->id,
            'name' => $this->name,
            'accessSelf' => $accessSelf,
            'accessForUser' => $this->when(isset($userIdAccessFor) && $userIdAccessFor != -1, 
                fn () => $this->getAccessForUser($userIdAccessFor)),            
        ];

        return $commonProps + $this->getSpecificProps($accessSelf[Access::Read->value]);
    }
}
