<?php

namespace App\Actions\V1\Approval;

use App\Models\WorkflowRequest;
use App\Traits\AuthTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetRequestsAction
{
    use AuthTrait;

    /**
     * @return Collection<int, WorkflowRequest>
     */
    public function handle(): Collection
    {
        if ($this->isHead()) {
            return $this->requestBuilder()
                ->whereIn('user_id', $this->subordinates()->pluck('id'))
                ->get();
        }

        return $this->requestBuilder()->get();
    }

    /**
     * @return Builder<WorkflowRequest>
     */
    private function requestBuilder(): Builder
    {
        return WorkflowRequest::whereHas('steps', function ($query) {
            $query->whereIn('role_id', $this->authUserRoleIds());
        })
            ->latest();
    }
}
