<?php

namespace App\Actions\V1\WorkflowRequests;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class IndexRequestAction
{
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, mixed>
     */
    public function handle(): LengthAwarePaginator
    {
        return Auth::user()
            ->requests()
            ->with(['workflow', 'user'])
            ->withCount('steps')
            ->latest()
            ->paginate(config('app.perPage'));
    }
}
