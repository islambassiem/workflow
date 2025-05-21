<?php

namespace App\Actions\V1\Step;

use App\Models\Step;
use App\Models\Workflow;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexStepAction
{
    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator<int, \App\Models\Step>
     */
    public function handle(Workflow $workflow): ?LengthAwarePaginator
    {
        Gate::authorize('view_any_step', Step::class);

        return Step::query()
            ->when($workflow, fn ($query) => $query->where('workflow_id', $workflow->id))
            ->orderBy('order', 'desc')
            ->paginate();
    }
}
