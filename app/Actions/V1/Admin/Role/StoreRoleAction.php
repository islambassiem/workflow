<?php

namespace App\Actions\V1\Admin\Role;

use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class StoreRoleAction
{
    /**
     * @param  array<string, string>  $attributes
     */
    public function handle(array $attributes): Role
    {
        Gate::authorize('create_a_role', Role::class);
        $role = Role::create($attributes);

        return $role instanceof Role ? $role : new Role((array) $role);
    }
}
