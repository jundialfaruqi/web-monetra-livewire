<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->newLine();
        $this->command->info('🚀 Starting Database Seeding...');
        $this->command->newLine();

        // 1. Create Permissions
        $this->command->comment('Step 1: Creating Permissions...');
        $permissions = [
            'user' => [
                'view-user',
                'add-user',
                'edit-user',
                'delete-user',
            ],
            'role-permission' => [
                'view-role-permission',
                'add-role',
                'edit-role',
                'delete-role',
                'add-permission',
                'edit-permission',
                'delete-permission',
            ],
            'example' => [
                'view-example',
                'add-example',
                'edit-example',
                'delete-example',
            ],
        ];

        foreach ($permissions as $group => $permissionList) {
            foreach ($permissionList as $permission) {
                Permission::updateOrCreate(
                    [
                        'name' => $permission,
                        'guard_name' => 'web'
                    ],
                    ['group' => $group]
                );
            }
        }
        $this->command->info('✔ Permissions created successfully.');

        // 2. Create Roles
        $this->command->newLine();
        $this->command->comment('Step 2: Creating Roles...');
        $superAdminRole = Role::updateOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
            'color' => '#ff0000'
        ]);
        $adminRole = Role::updateOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
            'color' => '#007bff'
        ]);
        $userRole = Role::updateOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
            'color' => '#2bff00'
        ]);
        $userExampleRole = Role::updateOrCreate([
            'name' => 'user-example',
            'guard_name' => 'web',
            'color' => '#ff00dd'
        ]);
        $this->command->info('✔ Roles created successfully.');

        // 3. Sync all permissions to Super Admin Role
        $this->command->newLine();
        $this->command->comment('Step 3: Syncing Permissions...');
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);
        $this->command->info('✔ All permissions synced to Super Admin.');

        // Sync example permissions to User Example Role
        $examplePermissions = Permission::where('group', 'example')->get();
        $userExampleRole->syncPermissions($examplePermissions);
        $this->command->info('✔ Example permissions synced to User Example Role.');

        // 4. Create Users and Assign Roles
        $this->command->newLine();
        $this->command->comment('Step 4: Creating Users & Assigning Roles...');

        $userData = [
            [
                'email' => 'superadmin@mail.com',
                'name' => 'Super Admin',
                'password' => 'password',
                'status' => 'active',
                'phone' => '+6281234567891',
                'address' => 'Jl. Super Admin No. 1',
                'email_verified_at' => now(),
                'role' => 'super-admin',
                'role_obj' => $superAdminRole
            ],
            [
                'email' => 'admin@mail.com',
                'name' => 'Admin',
                'password' => 'password',
                'status' => 'active',
                'phone' => '+6281234567890',
                'address' => 'Jl. Raya No. 123, Jakarta',
                'email_verified_at' => now(),
                'role' => 'admin',
                'role_obj' => $adminRole
            ],
            [
                'email' => 'user@mail.com',
                'name' => 'Regular User',
                'password' => 'password',
                'status' => 'active',
                'phone' => '+6281234567892',
                'address' => 'Jl. User No. 2',
                'email_verified_at' => now(),
                'role' => 'user',
                'role_obj' => $userRole
            ],
            [
                'email' => 'user@example.com',
                'name' => 'User Example',
                'password' => 'string',
                'status' => 'active',
                'phone' => '+6281234567893',
                'address' => 'Jl. Example No. 3',
                'email_verified_at' => now(),
                'role' => 'user-example',
                'role_obj' => $userExampleRole
            ]
        ];

        $displayUsers = [];
        foreach ($userData as $data) {
            $roleObj = $data['role_obj'];
            $roleName = $data['role'];
            $plainPassword = $data['password'];
            $status = $data['status'];

            unset($data['role'], $data['role_obj']);

            // Hash password for database
            $data['password'] = Hash::make($plainPassword);

            $user = User::updateOrCreate(['email' => $data['email']], $data);
            $user->assignRole($roleObj);

            $displayUsers[] = [$user->name, $user->email, $plainPassword, $roleName, $status];
        }

        $this->command->table(['Name', 'Email', 'Password', 'Role', 'Status'], $displayUsers);

        $this->command->newLine();
        $this->command->info('✨ Database Seeding Completed Successfully! ✨');
        $this->command->newLine();
    }
}
