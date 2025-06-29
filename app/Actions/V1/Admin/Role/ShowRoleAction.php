<?php

namespace App\Actions\V1\Admin\Role;

use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class ShowRoleAction
{
    public function handle(Role $role): Role
    {
        Gate::authorize('view_a_role', $role);

        return $role->load('permissions');
    }
}
