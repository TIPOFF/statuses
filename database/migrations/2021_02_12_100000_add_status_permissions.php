<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddStatusPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view statuses' => ['Owner', 'Staff'],
            'create statuses' => ['Owner'],
            'update statuses' => ['Owner'],
            'view status record' => ['Owner', 'Staff'],
            'create status record' => ['Owner'],
            'update status record' => ['Owner']
        ];

        $this->createPermissions($permissions);
    }
}
