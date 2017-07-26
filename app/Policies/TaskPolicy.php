<?php

namespace App\Policies;

use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user is owner of the given task
     *
     * @param  User $user
     * @param  Task $task
     * @return bool
     */
    public function owner(User $user, Task $task) :bool 
    {
        return $user->id == $task->user_id;
    }
}
