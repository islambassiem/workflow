<?php

namespace App\Actions\V1\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserRoleAction
{
    /**
     * @param  array<string, string>  $attributes
     */
    public function handle(User $user, array $attributes): User
    {
        Gate::authorize('update_a_user');

        $user->syncRoles($attributes);

        return $user->load('roles');
    }
}
