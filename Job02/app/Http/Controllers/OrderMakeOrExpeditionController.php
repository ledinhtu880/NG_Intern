<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\OrderMakeOrExpedition;

class OrderMakeOrExpeditionController extends Controller
{
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn sản xuất và giao hàng');
    }
    $data = OrderMakeOrExpedition::paginate(5);
    return view('makesOrExpeditions.index', compact('data'));
  }
  public function create()
  {
    $data = DB::table('Order')
      ->join('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
      ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->where('ContentSimple.ContainerProvided', 0)
      ->where('ContentSimple.PedestalProvided', 0)
      ->where('Order.isSimple', 1)
      ->whereNotIn('ContentSimple.Id_SimpleContent', function ($query) {
        $query->select('FK_Id_ContentSimple')
          ->from('ProcessContentSimple');
      })
      ->select('Order.Id_Order', 'Id_SimpleContent', 'Customer.Name_Customer', 'ContainerType.Name_ContainerType', 'ContentSimple.Count_Container', 'ContentSimple.Price_Container')
      ->get();
    $orders = OrderMakeOrExpedition::orderBy('Id_OrderMakeOrExpedition', 'desc')
      ->where('SimpleOrPack', 0)
      ->limit(200)
      ->paginate(10);
    return view('makesOrExpeditions.simples.create', compact('data', 'orders'));
  }
  public function store(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      $dateDilivery = $request->input('dateValue');
      $lastOrderId = DB::table('OrderMakeOrExpedition')->max('Id_OrderMakeOrExpedition');
      if ($lastOrderId === null) {
        $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
      } else {
        $id = $lastOrderId + 1;
      }
      $data = OrderMakeOrExpedition::create([
        'Id_OrderMakeOrExpedition' => $id,
        'Count' => 1,
        'DateDilivery' => $dateDilivery,
        'SimpleOrPack' => 0,
        'MakeOrExpedition' => 0,
        'Data_Start' => Carbon::now(),
      ]);
      if ($data) {
        foreach ($rowData as $row) {
          DB::table('DetailContentSimpleOrderMakeOrExpedition')->insert([
            'FK_Id_ContentSimple' => $row['Id_SimpleContent'],
            'FK_Id_OrderMakeOrExpedition' => $id,
          ]);
        }
        return response()->json([
          'status' => 'success',
          'data' => $data,
          'id' => $id,
        ]);
      }
    }
  }
  public function show(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $data = DB::table('ContentSimple')
        ->select('Name_RawMaterial', 'Count_RawMaterial', 'Name_ContainerType', 'Count_Container', 'Price_Container')
        ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
        ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
        ->join('DetailContentSimpleOrderMakeOrExpedition', 'Id_SimpleContent', '=', 'FK_Id_ContentSimple')
        ->where('FK_Id_OrderMakeOrExpedition', '=', $id)
        ->get();
      return response()->json([
        'status' => 'success',
        'data' => $data,
      ]);
    }
  }
  public function destroy(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      foreach ($rowData as $row) {
        DB::table('DetailContentSimpleOrderMakeOrExpedition')
          ->where('FK_Id_OrderMakeOrExpedition', '=', $row['Id_OrderMakeOrExpedition'])
          ->delete();
        DB::table('OrderMakeOrExpedition')
          ->where('Id_OrderMakeOrExpedition', '=', $row['Id_OrderMakeOrExpedition'])
          ->delete();
      }
      return response()->json([
        'status' => 'success',
      ]);
    }
  }
}
