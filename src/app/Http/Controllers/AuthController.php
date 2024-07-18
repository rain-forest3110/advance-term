<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::Paginate(4);
        return view('index', ['users' => $users])/*->name('login')*/;
    }

    /*public function index()
    {
        if (Auth::check())  {
            return view('index');
        }  else  {
            return view('login');
        }
    }*/

}
