<?php

namespace App\Actions\V1\Step;

use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UpdateStepAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(Step $step, array $attributes): Step
    {
        Gate::authorize('update_step', $step);

        $attributes['updated_by'] = Auth::id();
        $step->update($attributes);

        return $step->load(['createdBy', 'updatedBy']);
    }
}
