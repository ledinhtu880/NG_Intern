<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function checklogin(LoginRequest $request)
    {
        $user = User::where('Username', $request->username)->first();
        if ($user && Hash::check($request->password, $user->Password)) {
            Auth::login($user);
            $name = Auth::user()->Name;
            $request->session()->put('name', $name);
            return redirect()->intended('')->with('type', 'success')
                ->with('message', 'Đăng nhập thành công');
        } else {
            return redirect()->back()->with('type', 'warning')->with('message', 'Email hoặc mật khẩu không chính xác');
        }
    }
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login')->with('type', 'success')->with('message', 'Đăng xuất thành công');
    }
}
