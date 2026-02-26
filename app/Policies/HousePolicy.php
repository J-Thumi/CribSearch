<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\House;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HousePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user): bool
    {
        // Everyone with panel access can see the table, 
        // but the query filter (Step 3) will hide other people's rows.
        return true; 
    }

    public function view(User $user, House $house): bool
    {
        return $user->hasRole('super_admin') || $user->id === $house->scout_id;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:House');
    }

    public function update(User $user, House $house): bool
    {
        // Only the owner or an admin can edit
        return $user->hasRole('super_admin') || $user->id === $house->scout_id;
    }

    public function delete(User $user, House $house): bool
    {
        return $user->hasRole('super_admin') || $user->id === $house->scout_id;
    }


    public function restore(User $user, House $house): bool
    {
        return $user->hasRole('super_admin') || $user->id === $house->scout_id;
    }

    public function forceDelete(User $user, House $house): bool
    {
        return $user->hasRole('super_admin') || $user->id === $house->scout_id;
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:House');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:House');
    }

    public function replicate(AuthUser $authUser, House $house): bool
    {
        return $authUser->can('Replicate:House');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:House');
    }

}