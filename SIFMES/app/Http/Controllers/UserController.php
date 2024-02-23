<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý người dùng');
    }

    $users = User::paginate(5);
    return view('users.index', compact('users'));
  }
  public function create()
  {
    return view('users.create_update');
  }
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
      'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
    ]);
    $data['Password'] = bcrypt($data['Password']);
    $data['Id_User'] = User::getIdMax();
    $user = User::create($data);
    return redirect()->route('users.index')->with([
      'type' => 'success',
      'message' => 'Thêm người dùng thành công'
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
  public function update(Request $request, User $user)
  {
    $data = $request->validate([
      'Name' => 'required',
      'UserName' => [
        'required',
        'regex:/^\S*$/',
        Rule::unique('User')->ignore($user->Id_User, 'Id_User')
      ],
    ], [
      'Name.required' => 'Tên không được để trống',
      'UserName.required' => 'Tài khoản không được để trống',
      'UserName.unique' => 'Tài khoản đã tồn tại',
      'UserName.regex' => 'Tài khoản không được có khoảng trắng',
    ]);
    $user->update($data);
    return redirect()->route('users.index')->with([
      'type' => 'success',
      'message' => 'Cập nhật người dùng thành công'
    ]);
  }
  public function destroy(User $user)
  {
    DB::table('LinkRoleUser')->where('FK_Id_User', $user->Id_User)->delete();
    $user->delete();

    return redirect()->route('users.index')->with([
      'type' => 'success',
      'message' => 'Xóa người dùng thành công'
    ]);
  }
  public function showRoles(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $roles = DB::table('Role')
        ->join('LinkRoleUser', 'LinkRoleUser.FK_Id_Role', '=', 'Role.Id_Role')
        ->join('User', 'Id_User', '=', 'FK_Id_User')
        ->select('Id_Role', 'Name_Role')
        ->where('Id_User', '=', $id)
        ->get();
      return response()->json($roles);
    }
  }
  public function destroyUsers(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      foreach ($rowData as $row) {
        DB::table('LinkRoleUser')
          ->where('FK_Id_User', $row['Id_User'])
          ->delete();
        DB::table('User')
          ->where('Id_User', $row['Id_User'])
          ->delete();
      }
      return response()->json([
        'status' => 'success',
      ]);
    }
  }
  public function searchUsers(Request $request)
  {
    if ($request->ajax()) {
      $search = $request->input('searchValue');
      $data = DB::table('User')
        ->where('Name', 'like', '%' . $search . '%')
        ->orWhere('UserName', 'like', '%' . $search . '%')
        ->select('Id_User', 'Name', 'UserName')
        ->get();
      return response()->json($data);
    }
  }
}
