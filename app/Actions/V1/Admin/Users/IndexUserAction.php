<?php

namespace App\Actions\V1\Admin\Users;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexUserAction
{
    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function handle(?string $search = null): LengthAwarePaginator
    {
        Gate::authorize('view_any_user', User::class);

        return User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->with('roles')
            ->paginate(config('app.perPage'));
    }
}
