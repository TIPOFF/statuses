<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Statuses\Models\StatusRecord;
use Tipoff\Support\Contracts\Models\UserInterface;

class StatusRecordPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view status record') ? true : false;
    }

    public function view(UserInterface $user, StatusRecord $status_record): bool
    {
        return $user->hasPermissionTo('view status record') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create status record') ? true : false;
    }

    public function update(UserInterface $user, StatusRecord $status_record): bool
    {
        return $user->hasPermissionTo('update status record') ? true : false;
    }

    public function delete(UserInterface $user, StatusRecord $status_record): bool
    {
        return false;
    }

    public function restore(UserInterface $user, StatusRecord $status_record): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, StatusRecord $status_record): bool
    {
        return false;
    }
}
