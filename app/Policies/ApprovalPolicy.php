<?php

namespace App\Policies;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApprovalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view', Approval::class);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Approval $approval): bool
    {
        return $user->can('view', $approval);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create', Approval::class);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Approval $approval): bool
    {
        return $user->can('update', $approval);
    }

}
