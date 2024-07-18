<?php

namespace App\Http\Controllers;

use App\Models\User;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Fortify;

class RegisterController extends Controller
{
    public function createtest()
    {
        return view('auth.register');
    }

    public function storetest(Request $request)
    {
        try {
            // $userインスタンスを作成する
            $user = new User();

            // 投稿フォームから送信されたデータを取得し、インスタンスの属性に代入する
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');

            // データベースに保存
            $user->save();

            return back();
        } catch (\Exception $e) {
            return redirect()->route('auth.register')->with('message', '登録に失敗しました。' . $e->getMessage());
        }
    }


    



//ここからコピペ
        /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the registration view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\RegisterViewResponse
     */
    public function create(Request $request): RegisterViewResponse
    {
        return app(RegisterViewResponse::class);
    }

    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request,
                          CreatesNewUsers $creator): RegisterResponse
    {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        event(new Registered($user = $creator->create($request->all())));

        $this->guard->login($user);

        return app(RegisterResponse::class);
    }
    
}
