<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'workflow' => new WorkflowListResource($this->whenLoaded('workflow')),
            'user' => new UserListResource($this->whenLoaded('user')),
            'status' => $this->status,
            'priority' => $this->priority,
            'data' => $this->data,
        ];
    }
}
