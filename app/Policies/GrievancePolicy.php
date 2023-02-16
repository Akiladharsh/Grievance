<?php

namespace App\Policies;

use App\Models\Grievance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GrievancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('grievance read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Grievance $grievance)
    {
        return $user->hasPermissionTo('grievance read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('grievance create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Grievance $grievance)
    {
        return $user->hasPermissionTo('grievance update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Grievance $grievance)
    {
        return $user->hasPermissionTo('grievance delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Grievance $grievance)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Grievance $grievance)
    {
        //
    }
}
