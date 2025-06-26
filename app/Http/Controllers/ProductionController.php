<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Extra;
use App\Models\Item;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        $type = Extra::findOrFail(decrypt($type));
        $productions = Production::withTrashed()->where('type', $type->id)->latest()->get();
        return view('production.index', compact('productions', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        $type = Extra::findOrFail(decrypt($type));
        $entities = Entity::whereIn('type_id', [2, 3])->get();
        $items = Item::whereIn('type', [12, 13])->get();
        return view('production.create', compact('entities', 'items', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
