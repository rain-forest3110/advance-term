<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('index')->name('login');
    }

    /*public function index()
    {
        if (Auth::check())  {
            return view('index');
        }  else  {
            return view('login');
        }
    }*/


    /*public function index()
    {
        return view('index');
    }*/
}
