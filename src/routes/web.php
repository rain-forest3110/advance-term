<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;

//use App\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/', [AuthController::class, 'index']);

//Route::get('/', [AuthenticatedSessionController::class, 'index']);


/**
 * コメントアウト外せば、ログイン済みのみ表示にできる↓
 */
Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
});


//Route::get('/register', [RegisterController::class, 'createtest']);
//Route::post('/register', [RegisterController::class, 'storetest'])->name('users.store');
Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store'])/*->name('users.store')*/;


//Route::get('/login', [AuthenticatedSessionController::class, 'st']);
//Route::get('/login', [AuthenticatedSessionController::class, 'storetest'])->name('login');
//Route::post('/login', [AuthenticatedSessionController::class, 'destroytest'])->middleware('auth')->name('login');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');



/*Route::get('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

Route::get('/register', [RegisterController::class, 'create'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')]);