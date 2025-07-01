<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\UserBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function login()
    {
        return view('login');
    }

    function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password', 'remember');
        if (Auth::attempt($credentials)):
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with("success", "User authenticated succesfully");
        endif;
        return redirect()->back()->withInput($request->all())->with("error", "Invalid Credentials");
    }

    function dashboard()
    {
        $branches = Branch::whereIn('id', UserBranch::where('user_id', Auth::id())->pluck('branch_id'))->get();
        return view('dashboard', compact('branches'));
    }

    function updateBranch(Request $request)
    {
        $branch = Branch::findOrFail($request->branch);
        Session::put('branch', $branch);
        if (Session::has('branch')) :
            return redirect()->route('dashboard')
                ->withSuccess('User branch updated successfully!');
        else :
            return redirect()->route('dashboard')
                ->withError('Please update branch!');
        endif;
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with("success", "User logged out successfully");
    }
}
