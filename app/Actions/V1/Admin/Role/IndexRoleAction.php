<?php

namespace App\Actions\V1\Admin\Role;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class IndexRoleAction
{
    /**
     * Handle the action to retrieve a paginated list of roles.
     *
     * @return LengthAwarePaginator<int, Role>
     */
    public function handle(): LengthAwarePaginator
    {
        Gate::authorize('view_any_role', Role::class);

        return Role::with('permissions')
            ->latest()
            ->paginate(config('app.perPage'));
    }
}
