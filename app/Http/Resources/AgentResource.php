<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    public function toArray($request): array
    {
        $farmerModel = $this->farmer;
        $farmerUser = $farmerModel?->user;

        return [
            'id' => $this->id,
            'user' => (new UserResource($this->user))->toArray($request),
            'agent_code' => $this->agent_code,
            'is_verified' => $this->is_verified,
            'verified_at' => $this->verified_at?->format('F j, Y'),

            // Farmer Details
            'farmer_name' => $farmerUser
                ? "{$farmerUser->first_name} {$farmerUser->last_name}"
                : 'N/A',
            'farmer_role_id' => $farmerUser?->role_id, // e.g. 3-26-0001
            'farming_background' => $farmerModel?->farming_background ?? 'N/A',

            'qr_code_path' => $this->qrCode
                ? asset("storage/{$this->qrCode->image_path}")
                : null,
        ];
    }
}
