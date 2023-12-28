<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
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
        $role_id = DB::table('Role')->join('LinkRoleUser', 'Role.Id_Role', '=', 'LinkRoleUser.FK_Id_Role')->where('LinkRoleUser.FK_Id_User', $user_id)->get();
        return response()->json($role_id);
    }

    public function store(Request $request)
    {
        $roles = $request->input('role_id');
        $user_id = $request->input('user_id');
        DB::table('LinkRoleUser')->where('FK_Id_User', $user_id)->delete();
        foreach ($roles as $role_id){
            DB::table('LinkRoleUser')->insert([
                'FK_Id_User' => $user_id,
                'FK_Id_Role' => $role_id
            ]);
        }
    }
}
