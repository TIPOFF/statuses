<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Statuses\Models\Status;
use Tipoff\Support\Contracts\Models\UserInterface;

class StatusPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view statuses') ? true : false;
    }

    public function view(UserInterface $user, Status $Status): bool
    {
        return $user->hasPermissionTo('view statuses') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create statuses') ? true : false;
    }

    public function update(UserInterface $user, Status $status): bool
    {
        return $user->hasPermissionTo('update statuses') ? true : false;
    }

    public function delete(UserInterface $user, Status $status): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Status $status): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Status $status): bool
    {
        return false;
    }
}
