<?php

namespace App\Actions\V1\Approval;

use App\Models\Approval;
use Illuminate\Support\Facades\Gate;

class ShowApprovalAction
{
    public function handle(Approval $approval): Approval
    {
        Gate::authorize('view_approval', $approval);

        return $approval->load('user', 'request', 'step');
    }
}
