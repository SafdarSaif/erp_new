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
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // Academics
            'view universities',
            'create universities',
            'edit universities',
            'delete universities',
            'view departments',
            'create departments',
            'edit departments',
            'delete departments',
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'view sub courses',
            'create sub courses',
            'edit sub courses',
            'delete sub courses',
            'view subjects',
            'create subjects',
            'edit subjects',
            'delete subjects',

            // Students
            'view students',
            'create students',
            'edit students',
            'delete students',

            // Fees & Invoices
            'view fees',
            'create fees',
            'edit fees',
            'delete fees',
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',

            //settings permissions
            'view academic years',
            'create academic years',
            'edit academic years',
            'delete academic years',
            'view course types',
            'create course types',
            'edit course types',
            'delete course types',
            'view admission modes',
            'create admission modes',
            'edit admission modes',
            'delete admission modes',
            'view course modes',
            'create course modes',
            'edit course modes',
            'delete course modes',
            'view passout years',
            'create passout years',
            'edit passout years',
            'delete passout years',
            'view passout months',
            'create passout months',
            'edit passout months',
            'delete passout months',
            'view languages',
            'create languages',
            'edit languages',
            'delete languages',
            'view blood groups',
            'create blood groups',
            'edit blood groups',
            'delete blood groups',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view religions',
            'create religions',
            'edit religions',
            'delete religions',


            // Academics module
            'view universities',
            'create universities',
            'edit universities',
            'delete universities',
            'view departments',
            'create departments',
            'edit departments',
            'delete departments',
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'view sub courses',
            'create sub courses',
            'edit sub courses',
            'delete sub courses',
            'view subjects',
            'create subjects',
            'edit subjects',
            'delete subjects',


            'view university fee',

            'create reports',
            'view reports',
           
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
            'view students',
            'view fees',
            'view invoices',
        ]);
        $subCenterRole->syncPermissions([
            'view students',
            'view fees',
        ]);
        $operationHeadRole->syncPermissions([
            'view students',
        ]);
    }
}
