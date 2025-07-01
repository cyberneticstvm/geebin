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
            'item-list',
            'purchase-list',
            'purchase-create',
            'purchase-edit',
            'purchase-delete',
            'production-list',
            'production-create',
            'production-edit',
            'production-delete',
            'transfer-list',
            'transfer-create',
            'transfer-edit',
            'transfer-delete',
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

        Extra::insert(['id' => 1, 'key' => 'entity', 'value' => 'Supplier']);
        Extra::insert(['id' => 2, 'key' => 'entity', 'value' => 'Master Stock']);
        Extra::insert(['id' => 3, 'key' => 'entity', 'value' => 'Production Unit']);
        Extra::insert(['id' => 4, 'key' => 'entity', 'value' => 'Assembling Unit']);
        Extra::insert(['id' => 5, 'key' => 'entity', 'value' => 'Warehouse']);
        Extra::insert(['id' => 6, 'key' => 'entity', 'value' => 'Franchise']);
        Extra::insert(['id' => 7, 'key' => 'bstatus', 'value' => 'Open']);
        Extra::insert(['id' => 8, 'key' => 'bstatus', 'value' => 'Closed']);
        Extra::insert(['id' => 9, 'key' => 'unit', 'value' => 'Number']);
        Extra::insert(['id' => 10, 'key' => 'unit', 'value' => 'Kilo']);
        Extra::insert(['id' => 11, 'key' => 'unit', 'value' => 'Litre']);
        Extra::insert(['id' => 12, 'key' => 'itype', 'value' => 'Material']);
        Extra::insert(['id' => 13, 'key' => 'itype', 'value' => 'Color']);
        Extra::insert(['id' => 14, 'key' => 'itype', 'value' => 'Parts']);
        Extra::insert(['id' => 15, 'key' => 'itype', 'value' => 'Bin']);
        Extra::insert(['id' => 16, 'key' => 'itype', 'value' => 'Bag']);
        Extra::insert(['id' => 17, 'key' => 'itype', 'value' => 'Powder']);
        Extra::insert(['id' => 18, 'key' => 'itype', 'value' => 'Liquid']);
        Extra::insert(['id' => 19, 'key' => 'itype', 'value' => 'CocoPeat']);
        Extra::insert(['id' => 20, 'key' => 'itype', 'value' => 'Decom']);
        Extra::insert(['id' => 21, 'key' => 'entity', 'value' => 'LSGs']);
        Extra::insert(['id' => 22, 'key' => 'tstatus', 'value' => 'Pending']);
        Extra::insert(['id' => 23, 'key' => 'tstatus', 'value' => 'Approved']);
        Extra::insert(['id' => 24, 'key' => 'tstatus', 'value' => 'Rejected']);
        Extra::insert(['id' => 25, 'key' => 'itype', 'value' => 'Scrap']);
    }
}
