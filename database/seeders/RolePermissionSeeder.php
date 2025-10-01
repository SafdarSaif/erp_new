<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        // Define permissions per module
        $permissions = [
            // Users & Roles
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',

            // Academics
            'view universities', 'create universities', 'edit universities', 'delete universities',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view courses', 'create courses', 'edit courses', 'delete courses',
            'view sub courses', 'create sub courses', 'edit sub courses', 'delete sub courses',
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects',

            // Students
            'view students', 'create students', 'edit students', 'delete students',

            // Fees & Invoices
            'view fees', 'create fees', 'edit fees', 'delete fees',
            'view invoices', 'create invoices', 'edit invoices', 'delete invoices',

            //settings permissions
            'view academic years', 'edit academic years', 'create academic years', 'delete academic years'
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $centerRole = Role::firstOrCreate(['name' => 'Center']);
        $subCenterRole = Role::firstOrCreate(['name' => 'Sub-Center']);
        $operationHeadRole = Role::firstOrCreate(['name' => 'Operation-Head']);

        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());

        // Optional: Assign limited permissions to other roles
        $centerRole->syncPermissions([
            'view students', 'view fees', 'view invoices',
        ]);
        $subCenterRole->syncPermissions([
            'view students', 'view fees',
        ]);
        $operationHeadRole->syncPermissions([
            'view students',
        ]);
    }
}
