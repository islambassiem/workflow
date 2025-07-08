<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait AuthTrait
{
    /**
     * @return array<int, int>
     */
    public function authUserRoleIds(): array
    {
        return Auth::user()->roles()->whereNot('name', 'head')->pluck('id')->toArray();
    }

    public function isHead(): bool
    {
        return Auth::user()->hasRole('head');
    }

    /**
     * @return array<int, int>
     */
    private function subordinates(): array
    {
        return User::where('head_id', Auth::user()->id)->pluck('id')->toArray();
    }
}
