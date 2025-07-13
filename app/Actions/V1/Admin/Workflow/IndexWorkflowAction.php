<?php

namespace App\Actions\V1\Admin\Workflow;

use App\Models\Workflow;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexWorkflowAction
{
    /**
     * @return LengthAwarePaginator<int, Workflow> | Collection<int, Workflow>
     */
    public function handle(?string $search = null, bool $paginated = true): LengthAwarePaginator|Collection
    {
        $workflow = Workflow::withCount('steps')
            ->latest()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });

        return $paginated
            ? $workflow->paginate(config('app.perPage'))
            : $workflow->get();
    }
}
