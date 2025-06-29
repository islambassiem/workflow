<?php

namespace App\Actions\V1\Admin\Role;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class IndexRoleAction
{
    /**
     * Handle the action to retrieve a paginated list of roles.
     *
     * @return Collection<int, Role>
     */
    public function handle(): Collection
    {
        Gate::authorize('view_any_role', Role::class);

        return Role::with('permissions')
            ->latest()
            ->get();
    }
}
