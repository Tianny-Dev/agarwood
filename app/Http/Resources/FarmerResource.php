<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmerResource extends JsonResource
{
    public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'is_verified' => $this->is_verified,
        // New Farmer Specific Fields
        'farming_background' => $this->farming_background,
        'years_of_farming' => $this->years_of_farming,
        'familiarity_tree_cultivation' => $this->familiarity_tree_cultivation,
        'user' => [
            'name' => "{$this->user->first_name} {$this->user->last_name}",
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'phone_number' => $this->user->phone_number,
            'birthday' => $this->user->birthday,
            'gender' => $this->user->gender,
            'civil_status' => $this->user->civil_status,
            'address' => $this->user->address,
            'avatar' => $this->user->avatar,
        ]
    ];
}
}
