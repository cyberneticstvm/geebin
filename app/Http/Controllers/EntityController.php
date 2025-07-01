<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Entity;
use App\Models\Extra;
use App\Models\UserBranch;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class EntityController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('entity-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('entity-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('entity-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('entity-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('entity-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entities = Entity::withTrashed()->orderBy('name')->get();
        return view('entity.index', compact('entities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Extra::where('key', 'entity')->pluck('value', 'id');
        $branches = Branch::whereIn('id', UserBranch::where('user_id', Auth::user()->id)->pluck('branch_id'))->pluck('name', 'id');
        return view('entity.create', compact('types', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:entities,name',
            'code' => 'required|unique:entities,code',
            'address' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Entity::create($input);
        return redirect()->route('entity.register')->with("success", "Entity created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entity = Entity::findOrFail(decrypt($id));
        $types = Extra::where('key', 'entity')->pluck('value', 'id');
        $branches = Branch::whereIn('id', UserBranch::where('user_id', Auth::user()->id)->pluck('branch_id'))->pluck('name', 'id');
        return view('entity.edit', compact('entity', 'types', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $request->validate([
            'name' => 'required|unique:entities,name,' . $id,
            'code' => 'required|unique:entities,code,' . $id,
            'address' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        Entity::findOrFail($id)->update($input);
        return redirect()->route('entity.register')->with("success", "Entity updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Entity::findOrFail(decrypt($id))->delete();
        return redirect()->route('entity.register')->with("success", "Entity deleted successfully");
    }

    public function restore(string $id)
    {
        Entity::withTrashed()->where('id', decrypt($id))->restore();
        return redirect()->route('entity.register')->with("success", "Entity restored successfully");
    }
}
