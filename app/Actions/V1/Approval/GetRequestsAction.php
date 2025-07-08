<?php

namespace App\Actions\V1\Approval;

use App\Models\WorkflowRequest;
use App\Traits\AuthTrait;
use Illuminate\Database\Eloquent\Collection;

class GetRequestsAction
{
    use AuthTrait;

    /**
     * @return Collection<int, WorkflowRequest>
     */
    public function handle(): Collection
    {
        $builder = WorkflowRequest::query();

        if ($this->isHead()) {
            return $builder->whereHas('steps', function ($query) {
                $query->where('role_id', 2)
                    ->whereIn('user_id', $this->subordinates())
                    ->orWhereIn('role_id', $this->authUserRoleIds());
            })
                ->latest()
                ->get();
        }

        return $builder->whereHas('steps', function ($query) {
            $query->whereIn('role_id', $this->authUserRoleIds());
        })
            ->latest()
            ->get();
    }
}
