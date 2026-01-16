<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_paid' => $this->is_paid,
            'id_type' => $this->id_type,
            'id_front' => $this->id_front,
            'id_back' => $this->id_back,
            'agent_name' => $this->agent?->user
                ? "{$this->agent->user->first_name} {$this->agent->user->last_name}"
                : 'Direct / No Agent',
            'user' => [
                'name' => "{$this->user->first_name} {$this->user->last_name}",
                'first_name' => $this->user->first_name, // Add this
                'last_name' => $this->user->last_name,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'phone_number' => $this->user->phone_number,
                'avatar' => $this->user->avatar,
                'address' => $this->user->address,
                'birthday' => $this->user->birthday,
                'gender' => $this->user->gender,
                'civil_status' => $this->user->civil_status,
            ],
        ];
    }
}
