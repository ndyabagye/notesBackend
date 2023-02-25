<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notes;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the notes can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the notes can view the model.
     */
    public function view(User $user, Notes $model): bool
    {
        return true;
    }

    /**
     * Determine whether the notes can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the notes can update the model.
     */
    public function update(User $user, Notes $model): bool
    {
        return true;
    }

    /**
     * Determine whether the notes can delete the model.
     */
    public function delete(User $user, Notes $model): bool
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
     * Determine whether the notes can restore the model.
     */
    public function restore(User $user, Notes $model): bool
    {
        return false;
    }

    /**
     * Determine whether the notes can permanently delete the model.
     */
    public function forceDelete(User $user, Notes $model): bool
    {
        return false;
    }
}
