<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderType;
use App\Models\Customer;
use App\Models\RawMaterial;
use App\Models\ContainerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn hàng');
    }
    $data = Order::paginate(5);
    return view('orders.index', compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $customers = Customer::get();
    $types = OrderType::get();
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    return view('orders.create', [
      'customers' => $customers,
      'types' => $types,
      'containers' => $containers,
      'materials' => $materials,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
  }

  /**
   * Display the specified resource.
   */
  public function show(Order $order)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Order $order)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Order $order)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Order $order)
  {
    //
  }
  public function addProduct(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      $data = [];

      parse_str($formData, $formDataArray);

      $data[] = $formDataArray;

      return response()->json([
        'status' => 'success',
        'data' => $data,
      ]);
    }
  }
  public function storeOrder(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      $data = [];

      parse_str($formData, $formDataArray);

      $lastOrderId = DB::table('Order')->max('Id_Order');

      if ($lastOrderId === null) {
        $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
      } else {
        $id = $lastOrderId + 1;
      }

      $formDataArray['Id_Order'] = $id;

      $data[] = $formDataArray;
      DB::table('order')->insert([
        'Id_Order' => $id,
        'FK_Id_Customer' => $formDataArray['FK_Id_Customer'],
        'FK_Id_OrderType' => $formDataArray['FK_Id_OrderType'],
        'Date_Order' => $formDataArray['Date_Order'],
        'Date_Delivery' => $formDataArray['Date_Delivery'],
        'Date_Reception' => $formDataArray['Date_Reception'],
        'Note' => $formDataArray['Note'],
      ]);

      return response()->json([
        'status' => 'success',
        'id' => $id,
      ]);
    }
  }
  public function storeProduct(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      foreach ($rowData as $row) {
        $lastOrderId = DB::table('ContentSimple')->max('Id_SimpleContent');

        if ($lastOrderId === null) {
          $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
        } else {
          $id = $lastOrderId + 1;
        }

        DB::table('ContentSimple')->insert([
          'Id_SimpleContent' => $id,
          'FK_Id_RawMaterial' => $row['FK_Id_RawMaterial'],
          'Count_RawMaterial' => $row['Count_RawMaterial'],
          'FK_Id_ContainerType' => $row['FK_Id_ContainerType'],
          'Count_Container' => $row['Count_Container'],
          'Price_Container' => $row['Price_Container'],
          'FK_Id_Order' => $row['FK_Id_Order'],
          'ContainerProvided' => $row['ContainerProvided'],
          'PedestalProvided' => $row['PedestalProvided'],
          'RFIDProvided' => $row['RFIDProvided'],
          'RawMaterialProvided' => $row['RawMaterialProvided'],
        ]);
      }

      return response()->json([
        'status' => 'success',
      ]);
    }
  }
}
