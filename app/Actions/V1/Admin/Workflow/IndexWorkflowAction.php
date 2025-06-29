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
    public function handle(?string $search = null): LengthAwarePaginator
    {
        Gate::authorize('view_any_workflow', Workflow::class);

        return Workflow::withCount('steps')
            ->latest()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(config('app.perPage'));
    }
}
