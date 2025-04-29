<?php

namespace App\Services\Permission;

use App\Services\BaseModelService;
use Spatie\Permission\Models\Permission;

class PermissionService extends BaseModelService
{
    public function model(): string
    {
        return Permission::class;
    }

    public function getPermissions()
    {
        $permissions = $this->model()::get()->groupBy('group_name');
        return $permissions;
    }
}
