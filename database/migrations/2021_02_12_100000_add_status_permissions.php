<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddStatusPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view statuses' => ['Owner', 'Executive', 'Staff'],
            'create statuses' => ['Owner', 'Executive'],
            'update statuses' => ['Owner', 'Executive'],
            'view status record' => ['Owner', 'Executive', 'Staff'],
            'create status record' => ['Owner', 'Executive', 'Staff'],
            'update status record' => ['Owner', 'Executive', 'Staff'],
        ];

        $this->createPermissions($permissions);
    }
}
