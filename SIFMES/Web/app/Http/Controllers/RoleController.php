<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  public function index()
  {
    // $users = User::all();
    $users = User::select('Id_User', 'Name')->where('Username', '!=', 'admin')->get();
    $roles = DB::table('Role')->get();
    $type_role = [
      0 => 'Quản lý',
      1 => 'Quản lý đơn nội bộ',
      2 => 'Theo dõi',
      3 => 'Quản trị hệ thống'
    ];

    return view('roles.index', compact('users', 'roles', 'type_role'));
  }

  public function showRoleByUser(Request $request)
  {
    $user_id = $request->input('user_id');
    $role_id = DB::table('Role')
      ->join('LinkRoleUser', 'Role.Id_Role', '=', 'LinkRoleUser.FK_Id_Role')
      ->where('LinkRoleUser.FK_Id_User', $user_id)
      ->get();

    return response()->json($role_id);
  }

  public function store(Request $request)
  {
    $roles = $request->input('role_id');
    $user_id = $request->input('user_id');

    DB::table('LinkRoleUser')->where('FK_Id_User', $user_id)->delete();

    if ($roles != null) {
      foreach ($roles as $role_id) {
        DB::table('LinkRoleUser')->insert([
          'FK_Id_User' => $user_id,
          'FK_Id_Role' => $role_id
        ]);
      }
    }

    $roles = DB::table('LinkRoleUser')
      ->join('Role', 'FK_Id_Role', '=', 'Id_Role')
      ->where('FK_Id_User', $user_id)
      ->select('FK_Id_Role', 'Name_Role')
      ->get();

    $redirectUrl = redirect()->route('index');

    if (!$roles->contains('FK_Id_Role', 13)) {
      $redirectUrl = $redirectUrl->with('type', 'success')
        ->with('message', 'Đăng ký vai trò thành công!');
    } else {
      $redirectUrl = $redirectUrl->with('type', 'success')
        ->with('message', 'Đăng ký vai trò thành công!');
    }

    return response()->json(['url' => $redirectUrl->getTargetUrl()]);
  }

  public function checkUser(Request $request)
  {
    if ($request->ajax()) {
      $user_id = $request->input('user_id');
      $username = DB::table('User')->where('Id_User', $user_id)->value('UserName');
      $flag = $username == 'admin' ? true : false;

      return response()->json($flag);
    }
  }
}
