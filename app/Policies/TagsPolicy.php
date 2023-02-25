<?php

namespace App\Policies;

use App\Models\Tags;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the tags can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the tags can view the model.
     */
    public function view(User $user, Tags $model): bool
    {
        return true;
    }

    /**
     * Determine whether the tags can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the tags can update the model.
     */
    public function update(User $user, Tags $model): bool
    {
        return true;
    }

    /**
     * Determine whether the tags can delete the model.
     */
    public function delete(User $user, Tags $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the tags can restore the model.
     */
    public function restore(User $user, Tags $model): bool
    {
        return false;
    }

    /**
     * Determine whether the tags can permanently delete the model.
     */
    public function forceDelete(User $user, Tags $model): bool
    {
        return false;
    }
}
