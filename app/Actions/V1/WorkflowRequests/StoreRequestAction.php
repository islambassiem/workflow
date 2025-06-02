<?php

namespace App\Actions\V1\WorkflowRequests;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\User;
use App\Models\WorkflowRequest;
use Illuminate\Support\Facades\Gate;

class StoreRequestAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(User $user, array $attributes): WorkflowRequest
    {

        // Gate::authorize('create', WorkflowRequest::class);

        $attributes['status'] = Status::PENDING;
        $attributes['priority'] = Priority::LOW;

        $request = $user->requests()->create($attributes);

        return $request->load('workflow', 'user');
    }
}
