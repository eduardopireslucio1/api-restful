<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (integer) $this->id,
            'name' => (string) $this->name,
            'phone' => (integer) $this->phone,
            'address' => (string) $this->address,
            'email' => (string) $this->email,
            'created_at' => (string) $this->created_at,
        ];
    }
}
