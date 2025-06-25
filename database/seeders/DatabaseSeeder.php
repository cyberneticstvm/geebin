<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\User;
use App\Models\UserBranch;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'branch-list',
            'branch-create',
            'branch-edit',
            'branch-delete',
            'entity-list',
            'entity-create',
            'entity-edit',
            'entity-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'mail@cybernetics.me',
            'password' => Hash::make('stupid'),
        ]);

        $branch = Branch::create([
            'name' => 'Kottayam',
            'code' => 'KTM',
            'contact_number' => '0123456789',
            'address' => 'Perumbavoor',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $role = Role::create(['name' => 'Administrator']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        UserBranch::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        Extra::create(['key' => 'entity', 'value' => 'Supplier']);
        Extra::create(['key' => 'entity', 'value' => 'Production Unit']);
        Extra::create(['key' => 'entity', 'value' => 'Assembling Unit']);
        Extra::create(['key' => 'entity', 'value' => 'Warehouse']);
    }
}
