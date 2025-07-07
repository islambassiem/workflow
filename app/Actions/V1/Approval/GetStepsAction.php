<?php

namespace App\Actions\V1\Approval;

use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Traits\AuthTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetStepsAction
{
    use AuthTrait;

    public function __construct(public WorkflowRequest $request) {}

    /**
     * @return Collection<int, WorkflowRequestStep>
     */
    public function handle(): Collection
    {
        return $this->stepsBuilder()
            ->when($this->isHead(), function ($query) {
                $query->whereIn('user_id', $this->subordinates())
                    ->orWhereIn('role_id', $this->authUserRoleIds());
            })
            ->get();
    }

    /**
     * @return Builder<WorkflowRequestStep>
     */
    private function stepsBuilder(): Builder
    {
        return WorkflowRequestStep::where('workflow_request_id', $this->request->id)
            ->whereIn('role_id', $this->authUserRoleIds())
            ->latest();
    }
}
