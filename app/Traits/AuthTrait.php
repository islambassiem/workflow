<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

trait AuthTrait
{
    /**
     * @return array<int, int>
     */
    public function authUserRoleIds(): array
    {
        return Auth::user()->roles->pluck('id')->toArray();
    }

    public function isHead(): bool
    {
        return Auth::user()->hasRole('head');
    }

    /**
     * @return Collection<int, User>
     */
    private function subordinates(): Collection
    {
        return User::where('head_id', Auth::user())->get();
    }
}
