<?php

namespace App\Policies;

use App\Models\Sticker;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
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
     * @param  \App\Models\Sticker  $sticker
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user/*, Sticker $sticker*/)
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
        return $user->isAdministrator() ? Response::allow() : Response::denyWithStatus(403);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sticker  $sticker
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Sticker $sticker)
    {
        if(($user->id === $sticker->created_by) || $user->isSuperadministrator()) {
            Response::allow();
        } else {
            return Response::denyWithStatus(403);
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sticker  $sticker
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Sticker $sticker)
    {
        if((($user->id === $sticker->created_by) && $user->isAdministrator())
             || $user->isSuperadministrator()) {
            return Response::allow();
        } else {
            return Response::denyWithStatus(403);
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sticker  $sticker
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Sticker $sticker)
    {
        if((($user->id === $sticker->created_by) && $user->isAdministrator())
             || $user->isSuperadministrator()) {
            return Response::allow();
        } else {
            return Response::denyWithStatus(403);
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sticker  $sticker
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Sticker $sticker)
    {
        if((($user->id === $sticker->created_by) && $user->isAdministrator())
             || $user->isSuperadministrator()) {
            return Response::allow();
        } else {
            return Response::denyWithStatus(403);
        }
    }
}
