<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //public function index()
    //{
    //    return view('index')/*->name('login')*/;
    //}

    public function index()
    {
        if (Auth::check())  {
            return view('index');
        }  else  {
            return view('login');
        }
    }

}
