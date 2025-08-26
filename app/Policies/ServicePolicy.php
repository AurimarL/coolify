<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        return $user->isAdmin() && $user->teams()->get()->firstWhere('id', $service->team()->first()->id) !== null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function stop(User $user, Service $service): bool
    {
        return $user->teams()->get()->firstWhere('id', $service->team()->first()->id) !== null;
    }

    /**
     * Determine whether the user can manage environment variables.
     */
    public function manageEnvironment(User $user, Service $service): bool
    {
        return $user->isAdmin() && $user->teams()->get()->firstWhere('id', $service->team()->first()->id) !== null;
    }

    /**
     * Determine whether the user can deploy the service.
     */
    public function deploy(User $user, Service $service): bool
    {
        return $user->teams()->get()->firstWhere('id', $service->team()->first()->id) !== null;
    }
}
