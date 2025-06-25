<?php

namespace App\Http\Resources\V1;

use App\Models\User;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'steps_count' => WorkflowStep::where('workflow_id', $this->id)->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => new UserListResource(User::find($this->created_by)),
            'updated_by' => new UserListResource(User::find($this->updated_by)),
        ];
    }
}
