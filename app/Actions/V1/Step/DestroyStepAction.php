<?php

namespace App\Actions\V1\Step;

use App\Models\Step;
use Illuminate\Support\Facades\Gate;

class DestroyStepAction
{
    public function handle(Step $step): void
    {
        Gate::authorize('delete_step', $step);

        $step->delete();
    }
}
