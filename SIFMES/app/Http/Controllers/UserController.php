<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create_update');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'Name' => 'required',
            'UserName' => 'required|unique:User|regex:/^\S*$/',
            'Password' => 'required|min:6',
        ], [
            'Name.required' => 'Tên không được để trống',
            'UserName.required' => 'Tài khoản không được để trống',
            'UserName.unique' => 'Tài khoản đã tồn tại',
            'UserName.regex' => 'Tài khoản không được có khoảng trắng',
            'Password.required' => 'Mật khẩu không được để trống',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
        ]);
        $data['Password'] = bcrypt($data['Password']);
        $data['Id_User'] = User::getIdMax();
        $user = User::create($data);
        return redirect()->route('users.index')->with([
            'type' => 'success',
            'message' => 'Thêm ' . $user->Name . ' thành công'
        ]);
    }

    public function getUser(Request $request)
    {
        $user = User::find($request->Id_User);

        return $user;
    }

    public function edit(User $user)
    {
        return view('users.create_update', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'Name' => 'required',
            'UserName' => [
                'required',
                'regex:/^\S*$/',
                Rule::unique('User')->ignore($user->Id_User, 'Id_User')
            ],
            'Password' => 'required|min:6',
        ], [
            'Name.required' => 'Tên không được để trống',
            'UserName.required' => 'Tài khoản không được để trống',
            'UserName.unique' => 'Tài khoản đã tồn tại',
            'UserName.regex' => 'Tài khoản không được có khoảng trắng',
            'Password.required' => 'Mật khẩu không được để trống',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
        ]);
        $data['Password'] = bcrypt($data['Password']);
        $user->update($data);
        return redirect()->route('users.index')->with([
            'type' => 'success',
            'message' => 'Cập nhật ' . $user->Name . ' thành công'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with([
            'type' => 'success',
            'message' => 'Xóa ' . $user->Name . ' thành công'
        ]);
    }
}
