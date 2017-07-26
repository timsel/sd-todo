<?php

namespace App\Repositories;

use App\User;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    /**
     * Get tasks for a given user
     *
     * @param  User $user
     * @param bool $showall
     * @param null $search
     * 
     * @return Collection[]
     */
    public function filter(User $user, $showall = true, $search = null) :array
    {
        // allways show availables
        $available = $user->tasks()
            ->orderByDesc('created_at')
            ->where('done_at', '=', NULL)
            ->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%");
            })
            ->get();

        // show completed by request
        $completed = [];
        if ($showall) {
            $completed = $user->tasks()
                ->orderByDesc('done_at')
                ->where('done_at', '!=', NULL)
                ->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%");
                })
                ->get();
        }
        
        return [
            'available' => $available,
            'completed' => $completed,
        ];
    }
}