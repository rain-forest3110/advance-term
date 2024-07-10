<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisteredController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
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
}
