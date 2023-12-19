<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WareController extends Controller
{
  public function index()
  {
    return view("wares.index");
  }
  public function create()
  {
    $stations = DB::table('Station')->where('Id_Station', 406)->orWhere('Id_Station', 409)->get();
    return view('wares.create', compact('stations'));
  }
  public function show()
  {
    $stations = DB::table('Station')->where('Id_Station', 406)->orWhere('Id_Station', 409)->get();
    return view('wares.show', compact('stations'));
  }
  public function showDetails(Request $request)
  {
    $ware = $request->input("ware");
    if ($ware == 406) {
      $count = DB::table("DetailStateCellOfSimpleWareHouse")->where('Fk_Id_Station', $ware)->count();
      if ($count > 0) {
        $details = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->get();
        $col = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Colj');
        $row = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Rowi');
        return response()->json(['details' => $details, 'col' => $col, 'row' => $row]);
      }
      return response()->json(['count' => $count]);
    } else if ($ware == 409) {
      $count = DB::table("DetailStateCellOfPackWareHouse")->where('Fk_Id_Station', $ware)->count();
      if ($count > 0) {
        $details = DB::table('DetailStateCellOfPackWareHouse')->where('Fk_Id_Station', $ware)->get();
        $col = DB::table('DetailStateCellOfPackWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Colj');
        $row = DB::table('DetailStateCellOfPackWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Rowi');
        return response()->json(['details' => $details, 'col' => $col, 'row' => $row]);
      }
      return response()->json(['count' => $count]);
    }
  }
  /* public function createWare(Request $request)
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
      if ($ware == 406) {
        for ($i = 0; $i < count($data); $i++) {
          DB::table("DetailStateCellOfSimpleWareHouse")->insert([
            "Rowi" => $data[$i][0],
            "Colj" => $data[$i][1],
            "FK_Id_StateCell" => $data[$i][2],
            "Fk_Id_Station" => $ware,
            "Fk_Id_SimpleContent" => null,
          ]);
        }
      } elseif ($ware == 409) {
        for ($i = 0; $i < count($data); $i++) {
          DB::table("DetailStateCellOfPackWareHouse")->insert([
            "Rowi" => $data[$i][0],
            "Colj" => $data[$i][1],
            "FK_Id_StateCell" => $data[$i][2],
            "Fk_Id_Station" => $ware,
            "Fk_Id_PackContent" => null,
          ]);
        }
      }
      return response()->json(['success' => 'Khởi tạo kho thành công']);
    }
  } */
  public function createWare(Request $request)
  {
    $data = $request->input('data');
    $col = $request->input("col");
    $row = $request->input("row");
    $ware = $request->input("ware");

    // Kiểm tra sự tồn tại của kho
    $exists = DB::table("WareHouse")->where("FK_Id_Station", $ware)->exists();
    if ($exists) {
      return response()->json(['error' => 'Kho này đã tồn tại!']);
    }

    // Ghi thông tin kho vào bảng WareHouse
    DB::table("WareHouse")->insert([
      "FK_Id_Station" => $ware,
      "numRow" => $row,
      "numCol" => $col
    ]);

    // Tạo mảng dữ liệu để chèn vào bảng chi tiết dựa trên loại kho
    $detailData = [];
    $tableName = ($ware == 406) ? "DetailStateCellOfSimpleWareHouse" : "DetailStateCellOfPackWareHouse";
    $columnId = ($ware == 406) ? "Fk_Id_SimpleContent" : "Fk_Id_PackContent";

    // Tạo dữ liệu để chèn vào bảng chi tiết
    for ($i = 0; $i < count($data); $i++) {
      $detailData[] = [
        "Rowi" => $data[$i][0],
        "Colj" => $data[$i][1],
        "FK_Id_StateCell" => $data[$i][2],
        "Fk_Id_Station" => $ware,
        $columnId => null,
      ];
    }

    // Chèn dữ liệu vào bảng chi tiết tương ứng
    DB::table($tableName)->insert($detailData);

    return response()->json(['success' => 'Khởi tạo kho thành công']);
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
  public function showSimple(Request $request)
  {
    $id = $request->input('id');
    $data = DB::table('ContentSimple')
      ->select('Name_RawMaterial', 'Count_RawMaterial', 'Unit', 'Name_ContainerType', 'Count_Container', 'Price_Container')
      ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
      ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
      ->join('DetailStateCellOfSimpleWareHouse', 'Id_SimpleContent', '=', 'FK_Id_SimpleContent')
      ->where('FK_Id_SimpleContent', '=', $id)
      ->get();
    return response()->json($data);
  }
}
