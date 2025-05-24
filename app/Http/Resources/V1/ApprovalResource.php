<?php

namespace App\Http\Resources\V1;

use App\Models\Request as ModelsRequest;
use App\Models\Step;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalResource extends JsonResource
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
            'user' => new UserResource(User::find($this->approver_id)),
            'request' => new RequestResource(ModelsRequest::find($this->request_id)),
            'step' => new StepResource(Step::find($this->step_id)),
            'status' => $this->status->lable(),
            'comment' => $this->comment,
        ];
    }
}
