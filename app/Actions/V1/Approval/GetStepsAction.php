<?php

namespace App\Actions\V1\Approval;

use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Traits\AuthTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class GetStepsAction
{
    use AuthTrait;

    public function __construct(public WorkflowRequest $request) {}

    /**
     * @return LengthAwarePaginator<int, WorkflowRequestStep>
     */
    public function handle(): LengthAwarePaginator
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
                ->with(['step'])
                ->orderBy('order')
                ->paginate(config('app.perPage'));
        }

        return $builder
            ->whereIn('role_id', $this->authUserRoleIds())
            ->with(['step'])
            ->orderBy('order')
            ->paginate(config('app.perPage'));
    }
}
