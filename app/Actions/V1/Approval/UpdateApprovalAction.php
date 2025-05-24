<?php

namespace App\Actions\V1\Approval;

use App\Models\Approval;
use Illuminate\Support\Facades\Gate;

class UpdateApprovalAction
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function handle(Approval $approval, array $attributes): Approval
    {
        Gate::authorize('update_approval', $approval);

        $approval->update($attributes);

        return $approval->load('user', 'request', 'step');
    }
}
