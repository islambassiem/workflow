<?php

namespace App\Actions\V1\Admin\Permission;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class IndexPermissionAction
{
    /**
     * @return Collection<int, Permission>
     */
    public function handle(): Collection
    {
        Gate::authorize('view_permissions', Permission::class);

        return Permission::all();
    }
}
