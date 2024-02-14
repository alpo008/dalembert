<?php

namespace App\Policies;

use App\Models\AirmaxClient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AirmaxClientPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->isSuperadministrator() ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isAdministrator() ? Response::allow() : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user/*, AirmaxClient $airmaxClient*/)
    {
        return $user->isAdministrator() ? Response::allow() : Response::denyWithStatus(403);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isSuperdministrator() ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user/*, AirmaxClient $airmaxClient*/)
    {
        return $user->isSuperdministrator() ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user/*, AirmaxClient $airmaxClient*/)
    {
        return $user->isSuperdministrator() ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AirmaxClient $airmaxClient)
    {
        return $user->isSuperdministrator() ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AirmaxClient $airmaxClient)
    {
        return $user->isSuperdministrator() ? Response::allow() : Response::deny();
    }
}
