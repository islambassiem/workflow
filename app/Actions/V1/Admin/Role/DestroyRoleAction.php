<?php

namespace App\Actions\V1\Admin\Role;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class DestroyRoleAction
{
    public function handle(Role $role): void
    {
        Gate::authorize('delete_a_role');

        DB::transaction(function () use ($role) {
            try {
                DB::table('model_has_roles')->where('role_id', $role->id)->delete();
                DB::table('roles')->where('id', $role->id)->delete();
            } catch (QueryException $e) {
                if ($e->getCode() === '23000') {
                    throw ValidationException::withMessages([
                        'role' => 'This role is in use and cannot be deleted because it is referenced elsewhere.',
                    ]);
                }
            }
        });
    }
}
