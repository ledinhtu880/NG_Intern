<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
  public function show(Order $order)
  {
    $data = DB::table('ContentSimple')
      ->select('RawMaterial.Name_RawMaterial', 'ContentSimple.Count_RawMaterial', 'RawMaterial.unit', 'ContainerType.Name_ContainerType', 'ContentSimple.Count_Container', 'ContentSimple.Price_Container')
      ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->where('FK_Id_Order', $order->Id_Order)
      ->get();
    return view('orders.show', compact('order', 'data'));
  }
  public function create()
  {
    $customers = Customer::get();
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    return view('orders.create', [
      'customers' => $customers,
      'containers' => $containers,
      'materials' => $materials,
    ]);
  }
  public function edit(Order $order)
  {
    $customers = Customer::get();
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    $data = DB::table('ContentSimple')
      ->select(
        'ContentSimple.Id_SimpleContent',
        'RawMaterial.Name_RawMaterial',
        'ContentSimple.FK_Id_RawMaterial',
        'ContentSimple.Count_RawMaterial',
        'RawMaterial.unit',
        'ContentSimple.FK_Id_ContainerType',
        'ContainerType.Name_ContainerType',
        'ContentSimple.Count_Container',
        'ContentSimple.Price_Container'
      )
      ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->where('FK_Id_Order', $order->Id_Order)
      ->get();
    return view('orders.edit', [
      'order' => $order,
      'customers' => $customers,
      'containers' => $containers,
      'materials' => $materials,
      'data' => $data,
    ]);
  }
  public function destroy(Order $order)
  {
    DB::table('ContentSimple')->where('FK_Id_Order', $order->Id_Order)->delete();
    $order->delete();
    return redirect()->back()->with([
      'message' => 'Xóa đơn hàng thành công',
      'type' => 'danger',
    ]);
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
        'Date_Order' => $formDataArray['Date_Order'],
        'Date_Dilivery' => $formDataArray['Date_Dilivery'],
        'Date_Reception' => $formDataArray['Date_Reception'],
        'Note' => $formDataArray['Note'],
        'IsSimple' => 1,
      ]);

      return response()->json([
        'status' => 'success',
        'id' => $id,
      ]);
    }
  }
  public function updateOrder(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      $id = $request->input('id');
      $data = [];

      parse_str($formData, $formDataArray);

      $data[] = $formDataArray;
      DB::table('Order')->where('Id_Order', $id)->update([
        'FK_Id_Customer' => $formDataArray['FK_Id_Customer'],
        'Date_Order' => $formDataArray['Date_Order'],
        'Date_Dilivery' => $formDataArray['Date_Dilivery'],
        'Date_Reception' => $formDataArray['Date_Reception'],
        'Note' => $formDataArray['Note'],
      ]);

      return response()->json([
        'status' => 'success',
        'id' => $id,
      ]);
    }
  }
}
