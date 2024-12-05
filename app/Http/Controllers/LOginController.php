<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LOginController extends Controller
{

    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $role = Auth::user()->role; // Get the role of the authenticated user

        switch ($role) {
            case 'admin':
                return 'users.admin-dashboard';
            case 'manager':
                return 'users.manager-dashboard';
            case 'user':
                return 'users.user-dashboard';
            default:
                return '/'; // Default redirection if no role is matched
        }
    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
}
