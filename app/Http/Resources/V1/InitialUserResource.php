<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InitialUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'email_verified' => (bool) $this->email_verified_at,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
        ];
    }
}
