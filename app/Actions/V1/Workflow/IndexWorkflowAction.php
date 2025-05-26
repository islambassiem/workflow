<?php

namespace App\Actions\V1\Workflow;

use App\Models\Workflow;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexWorkflowAction
{
    /**
     * @return LengthAwarePaginator<int, Workflow>
     */
    public function handle(): LengthAwarePaginator
    {
        Gate::authorize('view_any_workflow', Workflow::class);

        return Workflow::paginate();
    }
}
