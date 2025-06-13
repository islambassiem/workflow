<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class WorkflowStepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \Spatie\Permission\Models\Role $role */
        $role = Role::find($this->approver_id);

        return [
            'id' => $this->id,
            'workflow' => new WorkflowListResource($this->whenLoaded('workflow')),
            'name' => $this->name,
            'description' => $this->description,
            'order' => $this->order,
            'role_id' => $this->role_id,
            'created_by' => new UserListResource($this->whenLoaded('createdBy')),
            'updated_by' => new UserListResource($this->whenLoaded('updatedBy')),
        ];
    }
}
