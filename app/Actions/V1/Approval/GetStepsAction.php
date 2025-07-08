<?php

namespace App\Actions\V1\Approval;

use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Traits\AuthTrait;
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

        $builder = WorkflowRequestStep::where('workflow_request_id', $this->request->id);

        if ($this->isHead()) {
            return $builder
                ->where(function ($query) {
                    $query->where('role_id', 2)
                        ->whereHas('request', function ($subQuery) {
                            $subQuery->whereIn('user_id', $this->subordinates());
                        })
                        ->orWhereIn('role_id', $this->authUserRoleIds());
                })
                ->latest()
                ->get();
        }

        return $builder
            ->whereIn('role_id', $this->authUserRoleIds())
            ->latest()
            ->get();
    }
}
