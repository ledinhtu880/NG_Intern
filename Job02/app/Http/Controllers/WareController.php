<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WareController extends Controller
{
  public function index()
  {
    $wares = DB::table('WareHouse')->get();
    return view("wares.index", compact('wares'));
  }
  public function create()
  {
    $stations = DB::table('Station')->get();
    return view('wares.create', compact('stations'));
  }
  public function show()
  {
    $stations = DB::table('Station')->get();
    return view('wares.show', compact('stations'));
  }
  public function showDetails(Request $request)
  {
    $ware = $request->input("kho");
    $count = DB::table("DetailStateCellOfSimpleWareHouse")->where('Fk_Id_Station', $ware)->count();
    if ($count > 0) {
      $details = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->get();
      $col = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Colj');
      $row = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Rowi');
      return response()->json(['details' => $details, 'col' => $col, 'row' => $row]);
    }
    return response()->json(['count' => $count]);
  }
  public function createWare(Request $request)
  {
    $data = $request->input('data');
    $col = $request->input("col");
    $row = $request->input("row");
    $ware = $request->input("ware");
    $exists = DB::table("WareHouse")->where("FK_Id_Station", $ware)->exists();
    if ($exists) {
      return response()->json(['error' => 'Kho này đã tồn tại!']);
    } else {
      DB::table("WareHouse")->insert([
        "FK_Id_Station" => $ware,
        "numRow" => $row,
        "numCol" => $col
      ]);
      for ($i = 0; $i < count($data); $i++) {
        DB::table("DetailStateCellOfSimpleWareHouse")->insert([
          "Rowi" => $data[$i][0],
          "Colj" => $data[$i][1],
          "FK_Id_StateCell" => $data[$i][2],
          "Fk_Id_Station" => $ware,
          "Fk_Id_SimpleContent" => null,
        ]);
      }
      return response()->json(['success' => 'Khởi tạo kho thành công']);
    }
  }
  public function setCellStatus(Request $request)
  {
    $col = $request->input("col");
    $row = $request->input("row");
    $ware = $request->input("ware");
    $status = $request->input("status");
    DB::table("DetailStateCellOfSimpleWareHouse")
      ->where("FK_Id_Station", $ware)
      ->where("Rowi", $row)
      ->where("Colj", $col)
      ->update([
        'FK_Id_StateCell' => $status,
      ]);
  }
}
