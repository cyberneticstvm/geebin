<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    function materialFormula()
    {
        $formula = Formula::all();
        return view('misc.formula', compact('formula'));
    }
}
