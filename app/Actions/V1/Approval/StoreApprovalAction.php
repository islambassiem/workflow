<?php

namespace App\Actions\V1\Approval;

use App\Models\Approval;
use Illuminate\Support\Facades\Gate;

class StoreApprovalAction
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function handle(array $attributes): Approval
    {
        Gate::authorize('create_approval', Approval::class);

        $approval = Approval::create($attributes);

        return $approval->load('user', 'request', 'step');
    }
}
