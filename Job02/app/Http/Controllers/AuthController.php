<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $name = Auth::user()->name;

            // Lưu tên người dùng vào session store
            $request->session()->put('name', $name);

            return redirect()->intended('')->with('type', 'success')
                ->with('message', 'Đăng nhập thành công');
        }

        return redirect()->route('index')->with('type', 'warning')->with('message', 'Email hoặc mật khẩu không chính xác');
    }
    public function logout()
    {
        Auth::logout();

        return redirect()->route('index')->with('type', 'info')->with('message', 'Đăng xuất thành công');
    }
}
