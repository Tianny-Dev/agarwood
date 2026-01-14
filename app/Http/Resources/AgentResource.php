<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => (new UserResource($this->user))->toArray($request),
            'agent_code' => $this->agent_code,
            'is_verified' => $this->is_verified,
            'verified_at' => $this->verified_at?->format('F j, Y'),
            'qr_code_path' => $this->qrCode
                ? asset("storage/{$this->qrCode->image_path}")
                : null,
        ];
    }
}
