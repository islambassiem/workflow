<?php

namespace App\Actions\V1\Approval;

use App\Http\Resources\V1\ApprovalResource;
use App\Models\Approval;
use App\Models\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexApprovalAction
{
    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator<int, \App\Models\Approval>
     */
    public function handle(Request $request): LengthAwarePaginator
    {
        Gate::authorize('view_any_request', $request);

        return  Approval::query()
            ->when($request, fn ($query) => $query->where('request_id', $request->id))
            ->orderBy('created_at', 'desc')
            ->paginate();
    }
}
