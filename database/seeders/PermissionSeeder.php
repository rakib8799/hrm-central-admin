<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();

        $permissions = [
            [
                'id' => 1,
                'name' => 'can-create-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'can-edit-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'can-delete-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'can-view-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'name' => 'can-view-details-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 6,
                'name' => 'can-create-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 7,
                'name' => 'can-edit-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 8,
                'name' => 'can-delete-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 9,
                'name' => 'can-view-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 10,
                'name' => 'can-view-details-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 11,
                'name' => 'can-create-permission',
                'guard_name' => 'web',
                'group_name' => 'Permission Management',
                'is_active' => true,
            ],
            [
                'id' => 12,
                'name' => 'can-edit-permission',
                'guard_name' => 'web',
                'group_name' => 'Permission Management',
                'is_active' => true,
            ],
            [
                'id' => 13,
                'name' => 'can-delete-permission',
                'guard_name' => 'web',
                'group_name' => 'Permission Management',
                'is_active' => true,
            ],
            [
                'id' => 14,
                'name' => 'can-view-configuration',
                'guard_name' => 'web',
                'group_name' => 'Configuration Management',
                'is_active' => true,
            ],
            [
                'id' => 15,
                'name' => 'can-edit-configuration',
                'guard_name' => 'web',
                'group_name' => 'Configuration Management',
                'is_active' => true,
            ],
            [
                'id' => 16,
                'name' => 'can-edit-company',
                'guard_name' => 'web',
                'group_name' => 'Company Management',
                'is_active' => true,
            ],
            [
                'id' => 17,
                'name' => 'can-view-company',
                'guard_name' => 'web',
                'group_name' => 'Company Management',
                'is_active' => true,
            ],
            [
                'id' => 18,
                'name' => 'can-view-details-company',
                'guard_name' => 'web',
                'group_name' => 'Company Management',
                'is_active' => true,
            ],
            [
                'id' => 19,
                'name' => 'can-create-subscription-plan',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Management',
                'is_active' => true,
            ],
            [
                'id' => 20,
                'name' => 'can-edit-subscription-plan',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Management',
                'is_active' => true,
            ],
            [
                'id' => 21,
                'name' => 'can-view-subscription-plan',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Management',
                'is_active' => true,
            ],
            [
                'id' => 22,
                'name' => 'can-view-details-subscription-plan',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Management',
                'is_active' => true,
            ],
            [
                'id' => 23,
                'name' => 'can-create-subscription-plan-feature',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Feature Management',
                'is_active' => true,
            ],
            [
                'id' => 24,
                'name' => 'can-edit-subscription-plan-feature',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Feature Management',
                'is_active' => true,
            ],
            [
                'id' => 25,
                'name' => 'can-view-subscription-plan-feature',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Feature Management',
                'is_active' => true,
            ],
            [
                'id' => 26,
                'name' => 'can-view-details-subscription-plan-feature',
                'guard_name' => 'web',
                'group_name' => 'Subscription Plan Feature Management',
                'is_active' => true,
            ],
            [
                'id' => 27,
                'name' => 'can-create-email-provider',
                'guard_name' => 'web',
                'group_name' => 'Email Provider Management',
                'is_active' => true,
            ],
            [
                'id' => 28,
                'name' => 'can-edit-email-provider',
                'guard_name' => 'web',
                'group_name' => 'Email Provider Management',
                'is_active' => true,
            ],
            [
                'id' => 29,
                'name' => 'can-view-email-provider',
                'guard_name' => 'web',
                'group_name' => 'Email Provider Management',
                'is_active' => true,
            ],
            [
                'id' => 30,
                'name' => 'can-view-details-email-provider',
                'guard_name' => 'web',
                'group_name' => 'Email Provider Management',
                'is_active' => true,
            ]
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
