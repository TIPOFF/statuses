<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddStatusPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view statuses',
            'create statuses',
            'update statuses'
        ];

        $this->createPermissions($permissions);
    }
}