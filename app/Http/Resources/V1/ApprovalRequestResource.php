<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalRequestResource extends JsonResource
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
            'user' => new UserListResource($this->whenLoaded('user')),
            'workflow' => new WorkflowResource($this->whenLoaded('workflow')),
            'data' => $this->data,
            'status' => $this->status->lable(),
            'priority' => $this->priority->lable(),
            'created_at' => $this->created_at,
        ];
    }
}
