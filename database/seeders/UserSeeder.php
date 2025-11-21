<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = User::firstOrCreate(
            ['email' => 'superadmins@example.com'], // Unique identifier
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'mobile' => '1234567891',
            ]
        );

        // Find the role
        $role = Role::firstOrCreate(['name' => 'Super Admin']);

        // Assign role only if not already assigned
        if (!$user->hasRole($role->name)) {
            $user->assignRole($role);
        }


        // -----------------------------------------------------
        // 2. ADD ANONYMOUS USER (ID = 0) WITH SUPER ADMIN ROLE
        // -----------------------------------------------------
        $anonymous = User::firstOrNew(['email' => 'anonymous@example.com']);

        $anonymous->id = 0;  // Force ID = 0
        $anonymous->name = 'Anonymous';
        $anonymous->password = Hash::make('password');
        $anonymous->mobile = '0000000000';
        $anonymous->saveQuietly();

        // Assign Super Admin role
        if (!$anonymous->hasRole($role->name)) {
            $anonymous->assignRole($role->name);
        }
    }

    //  public function run(): void
    // {
    //     // Create Super Admin
    //     $superAdminRole = Role::where('name', 'Super Admin')->first();

    //     $superAdmin = User::firstOrCreate(
    //         ['email' => 'superadmin@example.com'],
    //         [
    //             'name' => 'Super Admin',
    //             'password' => Hash::make('password'),
    //         ]
    //     );
    //     $superAdmin->assignRole($superAdminRole->name);

    //     // Create Center user
    //     $centerRole = Role::where('name', 'Center')->first();

    //     $centerUser = User::firstOrCreate(
    //         ['email' => 'center@example.com'],
    //         [
    //             'name' => 'Center User',
    //             'password' => Hash::make('password'),
    //         ]
    //     );
    //     $centerUser->assignRole($centerRole->name);

    //     // Create Sub-Center user
    //     $subCenterRole = Role::where('name', 'Sub-Center')->first();

    //     $subCenterUser = User::firstOrCreate(
    //         ['email' => 'subcenter@example.com'],
    //         [
    //             'name' => 'Sub-Center User',
    //             'password' => Hash::make('password'),
    //         ]
    //     );
    //     $subCenterUser->assignRole($subCenterRole->name);

    //     // Create Operation-Head user
    //     $operationHeadRole = Role::where('name', 'Operation-Head')->first();

    //     $operationHeadUser = User::firstOrCreate(
    //         ['email' => 'operation@example.com'],
    //         [
    //             'name' => 'Operation Head User',
    //             'password' => Hash::make('password'),
    //         ]
    //     );
    //     $operationHeadUser->assignRole($operationHeadRole->name);
    // }
}
