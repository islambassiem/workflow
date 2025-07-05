<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
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
        $updated_at =
            Carbon::parse($this->updated_at)->equalTo(Carbon::parse($this->created_at))
            ? null : $this->updated_at;

        return [
            'id' => $this->id,
            'step' => new WorkflowStepResource($this->whenLoaded('step')),
            'status' => $this->status->lable(),
            'order' => $this->order,
            'approver' => new RoleResource($this->whenLoaded('role')),
            'updated_at' => $updated_at,
            'comment' => $this->comment,
            'action_by' => new UserListResource($this->whenLoaded('actionBy')),
        ];
    }
}
