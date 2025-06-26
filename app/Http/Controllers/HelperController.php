<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Formula;
use App\Models\Item;
use App\Models\Material;
use App\Models\ProductionDetails;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class HelperController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('item-list'), only: ['items']),
        ];
    }

    function items()
    {
        $items = Item::all();
        return view('item.index', compact('items'));
    }
}
