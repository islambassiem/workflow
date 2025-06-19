<?php

namespace App\Actions\V1\Admin\Workflow;

use App\Models\Workflow;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexWorkflowAction
{
    /**
     * @return LengthAwarePaginator<int, Workflow>
     */
    public function handle()
    {
        Gate::authorize('view_any_workflow', Workflow::class);

        return Workflow::withCount('steps')->paginate(config('app.perPage'));
    }
}
