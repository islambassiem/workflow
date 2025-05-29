<?php

namespace App\Http\Resources\V1;

use App\Models\User;
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
        $approver = $this->approver_type->name === 'USER'
            ? new UserListResource(User::find($this->approver_id))
            : $role->name;

        return [
            'id' => $this->id,
            'workflow' => new WorkflowListResource($this->whenLoaded('workflow')),
            'name' => $this->name,
            'description' => $this->description,
            'order' => $this->order,
            'approver_type' => $this->approver_type,
            'approver' => $approver,
            'created_by' => new UserListResource($this->whenLoaded('createdBy')),
            'updated_by' => new UserListResource($this->whenLoaded('updatedBy')),
        ];
    }
}
