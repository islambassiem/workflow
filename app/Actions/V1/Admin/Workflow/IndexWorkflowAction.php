<?php

namespace App\Actions\V1\Admin\Workflow;

use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexWorkflowAction
{
    /**
     * @return LengthAwarePaginator<int, Workflow>
     */
    public function handle(Request $request): LengthAwarePaginator
    {
        Gate::authorize('view_any_workflow', Workflow::class);

        return Workflow::withCount('steps')
            ->latest()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            })
            ->paginate(config('app.perPage'));
    }
}
