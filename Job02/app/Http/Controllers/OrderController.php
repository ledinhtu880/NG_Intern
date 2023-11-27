<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\RawMaterial;
use App\Models\ContentPack;
use App\Models\ContainerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn thùng hàng');
    }
    $data = Order::where('SimpleOrPack', 0)->paginate(5);
    return view('simples.index', compact('data'));
  }
  public function show(Order $order)
  {
    $data = DB::table('ContentSimple')
      ->select(
        'RawMaterial.Name_RawMaterial',
        'ContentSimple.Count_RawMaterial',
        'RawMaterial.unit',
        'ContainerType.Name_ContainerType',
        'ContentSimple.Count_Container',
        'ContentSimple.Price_Container'
      )
      ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->where('FK_Id_Order', $order->Id_Order)
      ->get();
    return view('simples.show', compact('order', 'data'));
  }
  public function create()
  {
    $customers = Customer::get();
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    return view('simples.create', [
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
        'RawMaterial.Unit',
        'ContentSimple.FK_Id_ContainerType',
        'ContainerType.Name_ContainerType',
        'ContentSimple.Count_Container',
        'ContentSimple.Price_Container'
      )->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->where('FK_Id_Order', $order->Id_Order)
      ->get();
    return view('simples.edit', [
      'order' => $order,
      'customers' => $customers,
      'containers' => $containers,
      'materials' => $materials,
      'data' => $data,
    ]);
  }
  public function editOrder(string $Id_Order)
  {
    $contentPack = DB::table('ContentPack')->select('Id_PackContent', 'Count_Pack', 'Price_Pack')->where('FK_Id_Order', $Id_Order)->get();
    return view('packs.edits.editOrder', [
      'order' => Order::find($Id_Order),
      'customers' => Customer::all(),
      'contentPack' => $contentPack
    ]);
  }
  public function destroy(Order $order)
  {
    DB::table('ContentSimple')->where('FK_Id_Order', $order->Id_Order)->delete();
    $order->delete();
    return redirect()->route('orders.index')->with([
      'message' => 'Xóa đơn hàng thành công',
      'type' => 'success',
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
      DB::table('order')->insert([
        'Id_Order' => $id,
        'FK_Id_Customer' => $formDataArray['FK_Id_Customer'],
        'Date_Order' => $formDataArray['Date_Order'],
        'Date_Dilivery' => $formDataArray['Date_Dilivery'],
        'Date_Reception' => $formDataArray['Date_Reception'],
        'Note' => $formDataArray['Note'],
        'SimpleOrPack' => $formDataArray['SimpleOrPack'],
      ]);
      return response()->json([
        'status' => 'success',
        'id' => $id,
        'data' => $formDataArray
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

  public function updatePackAndCustomer(Request $request)
  {
    $order = $request->order;

    // Cập nhật vào bảng order
    $db_order = Order::find($order['Id_Order']);
    $db_order->FK_Id_Customer = $order['FK_Id_Customer'];
    $db_order->Date_Order = $order['Date_Order'];
    $db_order->Date_Dilivery = $order['Date_Dilivery'];
    $db_order->Date_Reception = $order['Date_Reception'];
    $db_order->Note = $order['Note'];
    $db_order->save();

    // Cập nhật bảng ContentPack
    $Id_PackContents = $request->idPackContents;
    $Count_Packs = $request->countPacks;
    for ($i = 0; $i < count($Id_PackContents); $i++) {
      $packContent = ContentPack::find($Id_PackContents[$i]);
      $packContent->Count_Pack = $Count_Packs[$i];
      $packContent->save();
    }
    $res = redirect()->route('packs.index')->with('type', 'success')->with('message', 'Sửa thành công');
    return response()->json([
      'url' => $res->getTargetUrl()
    ]);
  }
}
