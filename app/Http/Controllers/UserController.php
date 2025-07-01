<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\UserBranch;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-restore'), only: ['restore']),
        ];
    }

    public function index()
    {
        $users = User::withTrashed()->get();
        $branches = Branch::all();
        return view('user.index', compact('users', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $branches = Branch::pluck('name', 'id');
        return view('user.create', compact('roles', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'required',
            'branches' => 'required',
        ]);
        try {
            $input = $request->except(array('branches', 'roles'));
            $input['password'] = Hash::make($input['password']);
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            DB::transaction(function () use ($request, $input) {
                $user = User::create($input);
                $user->assignRole($request->input('roles'));
                $data = [];
                foreach ($request->branches as $key => $item):
                    $data[] = [
                        'user_id' => $user->id,
                        'branch_id' => $item,
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                UserBranch::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('user.register')->with("success", "User created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail(decrypt($id));
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $branches = Branch::pluck('name', 'id');
        return view('user.edit', compact('user', 'roles', 'userRole', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required',
            'branches' => 'required',
        ]);
        try {
            $input = $request->except(array('branches', 'roles'));
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }
            DB::transaction(function () use ($request, $input, $id) {
                $user = User::findOrFail($id);
                $user->update($input);
                DB::table('model_has_roles')->where('model_id', $id)->delete();
                $user->assignRole($request->input('roles'));
                foreach ($request->branches as $key => $item):
                    $data[] = [
                        'user_id' => $user->id,
                        'branch_id' => $item,
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                        'created_at' => $user->created_at,
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                UserBranch::where('user_id', $user->id)->forceDelete();
                UserBranch::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('user.register')->with("success", "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail(decrypt($id))->delete();
        return redirect()->route('user.register')->with("success", "User deleted successfully");
    }

    public function restore(string $id)
    {
        User::withTrashed()->where('id', decrypt($id))->restore();
        return redirect()->route('user.register')->with("success", "User restored successfully");
    }
}
