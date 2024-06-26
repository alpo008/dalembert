<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Calculation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CalculationPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): Response
    {
        return $user->isSuperadministrator() ? Response::allow() : Response::deny();
    }
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Calculation  $calculation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Calculation $calculation)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Calculation  $calculation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Calculation $calculation)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Calculation  $calculation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Calculation $calculation)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Calculation  $calculation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Calculation $calculation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Calculation  $calculation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Calculation $calculation)
    {
        //
    }
}
