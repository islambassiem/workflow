<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestStepResource extends JsonResource
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
            'step' => new WorkflowStepResource($this->whenLoaded('step')),
            'status' => $this->status->lable(),
            'order' => $this->order,
            'approved_at' => $this->approved_at,
            'rejected_at' => $this->rejected_at,
            'comment' => $this->comment,
            'action_by' => new UserListResource($this->whenLoaded('actionBy')),
        ];
    }
}
