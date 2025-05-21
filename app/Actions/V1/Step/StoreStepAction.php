<?php

namespace App\Actions\V1\Step;

use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreStepAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(array $attributes): Step
    {
        Gate::authorize('create_step', Step::class);

        $attributes['created_by'] = Auth::id();
        $step = Step::create($attributes);

        return $step->load(['createdBy', 'updatedBy']);
    }
}
