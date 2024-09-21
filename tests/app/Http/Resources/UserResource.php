<?php

namespace ToneflixCode\ResourceModifier\Tests\App\Http\Resources;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'name_email' => $this->name.' '.$this->email,
        ];
    }
}
