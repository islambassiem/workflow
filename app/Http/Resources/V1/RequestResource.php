<?php

namespace App\Http\Resources\V1;

use App\Models\User;
use App\Models\Workflow;
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
            'workflow' => new WorkflowResource(Workflow::find($this->workflow_id)),
            'user' => new UserResource(User::find($this->user_id)),
            'status' => $this->status->label(),
            'data' => $this->data,
        ];
    }
}
