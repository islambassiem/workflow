<?php

namespace App\Actions\V1\Approval;

use App\Models\WorkflowRequest;
use App\Traits\AuthTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class GetRequestsAction
{
    use AuthTrait;

    /**
     * @return LengthAwarePaginator<int, WorkflowRequest>
     */
    public function handle(): LengthAwarePaginator
    {
        $builder = WorkflowRequest::query();

        if ($this->isHead()) {
            return $builder->whereHas('steps', function ($query) {
                $query->where('role_id', 2)
                    ->whereIn('user_id', $this->subordinates())
                    ->orWhereIn('role_id', $this->authUserRoleIds());
            })
                ->with(['user', 'workflow'])
                ->latest()
                ->paginate(config('app.perPage'));
        }

        return $builder->whereHas('steps', function ($query) {
            $query->whereIn('role_id', $this->authUserRoleIds());
        })
            ->with(['user', 'workflow'])
            ->latest()
            ->paginate(config('app.perPage'));
    }
}
