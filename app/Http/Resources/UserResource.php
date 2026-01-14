<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'role_id' => $this->role_id,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'name' => trim($this->first_name 
                      . ' ' 
                      . ($this->middle_name ? $this->middle_name . ' ' : '') 
                      . $this->last_name),
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone_number' => $this->phone_number,
            'phone_number_verified_at' => $this->phone_number_verified_at,
            'birthday' => $this->birthday?->format('F j, Y'),
            'gender' => $this->gender,
            'civil_status' => $this->civil_status,
            'address' => $this->address,
            'avatar' => $this->avatar ? asset("storage/{$this->avatar}") : null,
            'cover' => $this->cover ? asset("storage/{$this->cover}") : null,
            'created_at' => $this->created_at?->format('F j, Y'),
            'updated_at' => $this->updated_at?->format('F j, Y'),
        ];
    }
}
