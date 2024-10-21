<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{
    public function index()
    {
        return view('home.dashboard');
    }

    public function logout()
    {
        if (\Auth::guard('web')->check() || \Auth::guard('faculty')->check()) {
            auth()->guard('web')->logout();
            auth()->guard('faculty')->logout();
            return redirect()->route('getLogin')->with('success', 'You have been Successfully Logged Out');
        } else {
            return redirect()->route('dash')->with('error', 'No authenticated user to log out');
        }
    }
}
