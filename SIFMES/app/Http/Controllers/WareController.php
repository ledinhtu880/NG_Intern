<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Casts\Json;
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
        $details = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->orderBy('Rowi', 'asc')->orderBy('Colj', 'asc')->get();
        $col = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Colj');
        $row = DB::table('DetailStateCellOfSimpleWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Rowi');
        return response()->json(['details' => $details, 'col' => $col, 'row' => $row]);
      }
      return response()->json(['count' => $count]);
    } else if ($ware == 409) {
      $count = DB::table("DetailStateCellOfPackWareHouse")->where('Fk_Id_Station', $ware)->count();
      if ($count > 0) {
        $details = DB::table('DetailStateCellOfPackWareHouse')->where('Fk_Id_Station', $ware)->orderBy('Rowi', 'asc')->orderBy('Colj', 'asc')->get();
        $col = DB::table('DetailStateCellOfPackWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Colj');
        $row = DB::table('DetailStateCellOfPackWareHouse')->where('Fk_Id_Station', $ware)->distinct()->count('Rowi');
        return response()->json(['details' => $details, 'col' => $col, 'row' => $row]);
      }
      return response()->json(['count' => $count]);
    }
  }
  public function createWare(Request $request)
  {
    // $data = $request->input('data');
    $data = json_decode(stripslashes($_POST['data']));
    $col = $request->input("col");
    $row = $request->input("row");
    $ware = $request->input("ware");
    $exists = DB::table("WareHouse")->where("FK_Id_Station", $ware)->exists();
    if ($exists) {
      return response()->json(['flag' => 0]);
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
            "Fk_Id_ContentSimple" => null,
          ]);
        }
      } elseif ($ware == 409) {
        for ($i = 0; $i < count($data); $i++) {
          DB::table("DetailStateCellOfPackWareHouse")->insert([
            "Rowi" => $data[$i][0],
            "Colj" => $data[$i][1],
            "FK_Id_StateCell" => $data[$i][2],
            "Fk_Id_Station" => $ware,
            "Fk_Id_ContentPack" => null,
          ]);
        }
      }
      return response()->json(['flag' => 1]);
    }
  }
  public function setCellStatus(Request $request)
  {
    $col = $request->input("col");
    $row = $request->input("row");
    $ware = $request->input("ware");
    $status = $request->input("status");

    if ($ware == 406) {
      DB::table("DetailStateCellOfSimpleWareHouse")
        ->where("FK_Id_Station", $ware)
        ->where("Rowi", $row)
        ->where("Colj", $col)
        ->update([
          'FK_Id_StateCell' => $status,
        ]);
    } else if ($ware == 409) {
      DB::table("DetailStateCellOfPackWareHouse")
        ->where("FK_Id_Station", $ware)
        ->where("Rowi", $row)
        ->where("Colj", $col)
        ->update([
          'FK_Id_StateCell' => $status,
        ]);
    }
  }
  public function showSimple(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $data = DB::table('ContentSimple')
        ->select(
          'RawMaterial.Name_RawMaterial',
          'ContentSimple.Count_RawMaterial',
          'RawMaterial.Unit',
          'ContainerType.Name_ContainerType',
          'ContentSimple.Price_Container',
          'ContentSimple.Count_Container',
        )
        ->selectRaw('(ContentSimple.Count_Container - COALESCE(SUM(RegisterContentSimpleAtWareHouse.Count), 0)) as SoLuong')
        ->join('RawMaterial', 'RawMaterial.Id_RawMaterial', '=', 'ContentSimple.FK_Id_RawMaterial')
        ->join('ContainerType', 'ContainerType.Id_ContainerType', '=', 'ContentSimple.FK_Id_ContainerType')
        ->join('DetailStateCellOfSimpleWareHouse', 'DetailStateCellOfSimpleWareHouse.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
        ->leftJoin('RegisterContentSimpleAtWareHouse', 'ContentSimple.Id_ContentSimple', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
        ->where('ContentSimple.Id_ContentSimple', '=', $id)
        ->groupBy(
          'RawMaterial.Name_RawMaterial',
          'ContentSimple.Count_RawMaterial',
          'RawMaterial.Unit',
          'ContainerType.Name_ContainerType',
          'ContentSimple.Count_Container',
          'ContentSimple.Price_Container'
        )
        ->get();
      return response()->json($data);
    }
  }
  public function showPack(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $data = DB::table('ContentPack')
        ->select('Id_ContentPack', 'Count_Pack', 'Price_Pack')
        ->selectRaw('(Count_Pack - COALESCE(SUM(RegisterContentPackAtWareHouse.Count), 0)) as SoLuong')
        ->leftJoin('RegisterContentPackAtWareHouse', 'Id_ContentPack', '=', 'FK_Id_ContentPack')
        ->where('Id_ContentPack', '=', $id)
        ->groupBy('Id_ContentPack', 'Count_Pack', 'Price_Pack')
        ->first();
      return response()->json($data);
    }
  }
  public function showSimpleInPack(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $data = DB::table('ContentSimple')
        ->select(
          'RawMaterial.Name_RawMaterial',
          'ContentSimple.Count_RawMaterial',
          'RawMaterial.Unit',
          'ContainerType.Name_ContainerType',
          'ContentSimple.Price_Container',
          'ContentSimple.Count_Container'
        )
        ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
        ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
        ->join('DetailContentSimpleOfPack', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOfPack.FK_Id_ContentSimple')
        ->join('DetailStateCellOfPackWareHouse', 'DetailStateCellOfPackWareHouse.FK_Id_ContentPack', '=', 'DetailContentSimpleOfPack.FK_Id_ContentPack')
        ->where('DetailStateCellOfPackWareHouse.FK_Id_ContentPack', '=', $id)
        ->get();
      return response()->json([
        'data' => $data,
      ]);
    }
  }
}
