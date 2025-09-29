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
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmins@example.com',
            'password' => Hash::make('password')
          ]);

          $role = Role::where('name', 'Super Admin')->first();
          $user->assignRole([$role->id]);
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
