<?php

namespace App\Http\Resources\V1;

use App\Models\User;
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
            'steps_count' => $this->steps_count,
            'created_by' => new UserListResource(User::find($this->created_by)),
            'updated_by' => new UserListResource(User::find($this->updated_by)),
        ];
    }
}
