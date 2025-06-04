<?php

namespace App\Services\V1;

use App\Models\User;
use App\Models\WorkflowRequestStep;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class StepApproverUserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(public WorkflowRequestStep $step)
    {
        //
    }

    /**
     * @return Collection<int, \App\Models\User> | User
     */
    public function handle(): Collection|User
    {
        $approver_id = $this->step->approver_id;

        if ($this->step->approver_type === "Spatie\Permission\Models\Role") {
            if (Role::find($approver_id)->name == 'head') {
                $requester = User::find($this->step->request->user_id);
                $head = User::find($requester->head);

                return $head;
            }
            $role = Role::find($approver_id);

            return User::role($role->name)->get();
        } else {
            return User::find($approver_id);
        }
    }
}
