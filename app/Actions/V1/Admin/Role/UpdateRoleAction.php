<?php

namespace App\Actions\V1\Admin\Role;

use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    /**
     * @param  array<string, string>  $attributes
     */
    public function handle(Role $role, array $attributes): Role
    {
        Gate::authorize('update_a_role', Role::class);

        $role->update($attributes);

        return $role;
    }
}
