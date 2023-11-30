<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\OrderLocal;
use App\Models\CustomerType;
use App\Models\RawMaterial;
use App\Models\ContainerType;

class OrderLocalController extends Controller
{
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn sản xuất và giao hàng');
    }
    $data = OrderLocal::paginate(5);
    return view('orderLocals.index', compact('data'));
  }
  public function create()
  {
    $customerType = CustomerType::get();
    return view('orderLocals.create', compact('customerType'));
  }

  public function store(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      $dateDilivery = $request->input('dateValue');
      $SimpleOrPack = $request->input('SimpleOrPack');
      $lastOrderId = DB::table('OrderLocal')->max('Id_OrderLocal');
      if ($lastOrderId === null) {
        $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
      } else {
        $id = $lastOrderId + 1;
      }

      $data = OrderLocal::create([
        'Id_OrderLocal' => $id,
        'Count' => 1,
        'DateDilivery' => $dateDilivery,
        'SimpleOrPack' => $SimpleOrPack,
        'MakeOrPackOrExpedition' => '0',
        'Data_Start' => Carbon::now(),
      ]);
      foreach ($rowData as $row) {
        DB::table('DetailContentSimpleOrderLocal')->insert([
          'FK_Id_ContentSimple' => $row['Id_SimpleContent'],
          'FK_Id_OrderLocal' => $id,
        ]);
      }
      return response()->json([
        'status' => 'success',
        'data' => $data,
        'id' => $id,
      ]);
    }
  }
  public function show(string $id)
  {
    $orderLocal = OrderLocal::where('Id_OrderLocal', $id)->first();
    $data = DB::table('ContentSimple')
      ->select('Name_RawMaterial', 'Count_RawMaterial', 'Unit',  'Name_ContainerType', 'Count_Container', 'Price_Container')
      ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
      ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
      ->join('DetailContentSimpleOrderLocal', 'Id_SimpleContent', '=', 'FK_Id_ContentSimple')
      ->where('FK_Id_OrderLocal', '=', $id)
      ->get();
    return view('orderLocals.show', compact('orderLocal', 'data'));
  }
  public function showDetail(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $data = DB::table('ContentSimple')
        ->select('Name_RawMaterial', 'Count_RawMaterial', 'Unit', 'Name_ContainerType', 'Count_Container', 'Price_Container')
        ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
        ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
        ->join('DetailContentSimpleOrderLocal', 'Id_SimpleContent', '=', 'FK_Id_ContentSimple')
        ->where('FK_Id_OrderLocal', '=', $id)
        ->get();
      return response()->json([
        'status' => 'success',
        'data' => $data,
        'id' => $id,
      ]);
    }
  }
  public function showSimpleByCustomerType(Request $request)
  {
    if ($request->ajax()) {
      $customerType = $request->input('id');
      $SimpleOrPack = $request->input('SimpleOrPack');
      $data = DB::table('Order')
        ->join('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
        ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
        ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
        ->join('CustomerType', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.Id')
        ->join('RawMaterial', 'FK_Id_RawMaterial', '=', 'Id_RawMaterial')
        ->where('Customer.FK_Id_CustomerType', $customerType)
        ->where('ContentSimple.ContainerProvided', 0)
        ->where('ContentSimple.PedestalProvided', 0)
        ->where('Order.SimpleOrPack', $SimpleOrPack)
        ->whereNotIn('ContentSimple.Id_SimpleContent', function ($query) {
          $query->select('FK_Id_ContentSimple')
            ->from('ProcessContentSimple');
        })
        ->select(
          'Id_SimpleContent',
          'Name_RawMaterial',
          'Count_RawMaterial',
          'Customer.Name_Customer',
          'ContainerType.Name_ContainerType',
          'ContentSimple.Count_Container',
          'ContentSimple.Price_Container'
        )
        ->get();

      return response()->json([
        'status' => 'success',
        'data' => $data,
      ]);
    }
  }
  public function showOrderByCustomerType(Request $request)
  {
    if ($request->ajax()) {
      $customerType = $request->input('id');
      $simpleOrPack = $request->input('SimpleOrPack');
      $orders = DB::table('OrderLocal')
        ->join('DetailContentSimpleOrderLocal', 'Id_OrderLocal', '=', 'FK_Id_OrderLocal')
        ->join('ContentSimple', 'Id_SimpleContent', '=', 'FK_Id_ContentSimple')
        ->join('Order', 'Id_Order', '=', 'FK_Id_Order')
        ->join('Customer', 'Id_Customer', '=', 'FK_Id_Customer')
        ->join('CustomerType', 'Id', '=', 'FK_Id_CustomerType')
        ->where('CustomerType.Id', $customerType)
        ->where('OrderLocal.SimpleOrPack', $simpleOrPack)
        ->groupBy('Id_OrderLocal', 'Count', 'DateDilivery', 'OrderLocal.SimpleOrPack', 'MakeOrPackOrExpedition', 'Data_Start', 'Data_Fin')
        ->select('OrderLocal.*')
        ->get();
      return response()->json([
        'status' => 'success',
        'orders' => $orders,
      ]);
    }
  }
  public function edit(string $id)
  {
    $orderLocal = OrderLocal::where('Id_OrderLocal', $id)->first();
    $materials = RawMaterial::get();
    $containers = ContainerType::get();
    $data = DB::table('ContentSimple')
      ->select('Id_SimpleContent', 'FK_Id_RawMaterial', 'Name_RawMaterial', 'Count_RawMaterial', 'Unit',  'FK_Id_ContainerType', 'Name_ContainerType', 'Count_Container', 'Price_Container')
      ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
      ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
      ->join('DetailContentSimpleOrderLocal', 'Id_SimpleContent', '=', 'FK_Id_ContentSimple')
      ->where('FK_Id_OrderLocal', '=', $id)
      ->get();
    if (session()->has('message') && session()->has('type')) {
      // Lấy nội dung của thông báo và loại thông báo
      $message = session()->get('message');
      $type = session()->get('type');
      return view('orderLocals.edit', compact('orderLocal', 'data', 'containers', 'materials'))
        ->with('type', 'success');
    }
    return view('orderLocals.edit', compact('orderLocal', 'data', 'containers', 'materials'));
  }

  public function addSimple(string $id)
  {
    $orderLocal = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->first();
    $customerType = DB::table('CustomerType')
      ->join('Customer', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.ID')
      ->join('Order', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
      ->join('ContentSimple', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->join('DetailContentSimpleOrderLocal', 'Id_SimpleContent', '=', 'FK_Id_ContentSimple')
      ->where('FK_Id_OrderLocal', $id)
      ->value('CustomerType.Id');
    $data = DB::table('Order')
      ->join('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
      ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('CustomerType', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.Id')
      ->join('RawMaterial', 'FK_Id_RawMaterial', '=', 'Id_RawMaterial')
      ->where('Customer.FK_Id_CustomerType', $customerType)
      ->where('ContentSimple.ContainerProvided', 0)
      ->where('ContentSimple.PedestalProvided', 0)
      ->where('Order.SimpleOrPack', $orderLocal->SimpleOrPack)
      ->whereNotIn('ContentSimple.Id_SimpleContent', function ($query) {
        $query->select('FK_Id_ContentSimple')
          ->from('ProcessContentSimple');
      })
      ->select(
        'Id_SimpleContent',
        'Name_RawMaterial',
        'Count_RawMaterial',
        'Customer.Name_Customer',
        'ContainerType.Name_ContainerType',
        'ContentSimple.Count_Container',
        'ContentSimple.Price_Container'
      )
      ->get();
    return view('orderLocals.makes.addSimple', compact('data', 'id'));
  }
  public function storeSimple(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      $id = $request->input('id');

      foreach ($rowData as $row) {
        DB::table('DetailContentSimpleOrderLocal')->insert([
          'FK_Id_ContentSimple' => $row['Id_SimpleContent'],
          'FK_Id_OrderLocal' => $id,
        ]);
      }
      $res = redirect()->route('orderLocals.edit', $id)
        ->with('type', 'success')
        ->with('message', 'Thêm thùng hàng vào đơn sản xuất thành công');
      return response()->json([
        'status' => 'success',
        'url' => $res->getTargetUrl()
      ]);
    }
  }
  public function update(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      $id = $request->input('Id_OrderLocal');
      $data = [];

      parse_str($formData, $formDataArray);

      $data[] = $formDataArray;
      DB::table('OrderLocal')->where('Id_OrderLocal', $id)->update([
        'Count' => $formDataArray['Count'],
        'SimpleOrPack' => $formDataArray['SimpleOrPack'],
        'MakeOrPackOrExpedition' => $formDataArray['MakeOrPackOrExpedition'],
        'DateDilivery' => $formDataArray['DateDilivery'],
        'Data_Start' => $formDataArray['Data_Start'],
        'Data_Fin' => $formDataArray['Data_Fin']
      ]);
      $res = redirect()->route('orderLocals.index')
        ->with('type', 'success')
        ->with('message', 'Sửa đơn hàng sản xuất thành công');
      return response()->json([
        'url' => $res->getTargetUrl()
      ]);
    }
  }
  public function destroyOrder(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      foreach ($rowData as $row) {
        DB::table('DetailContentSimpleOrderLocal')
          ->where('FK_Id_OrderLocal', '=', $row['Id_OrderLocal'])
          ->delete();
        DB::table('DispatcherOrder')
          ->where('FK_Id_OrderLocal', '=', $row['Id_OrderLocal'])
          ->delete();
        DB::table('OrderLocal')
          ->where('Id_OrderLocal', '=', $row['Id_OrderLocal'])
          ->delete();
      }
      return response()->json([
        'status' => 'success',
      ]);
    }
  }
  public function destroySimple(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_ContentSimple', $id)->delete();
      return response()->json([
        'status' => 'success'
      ]);
    }
  }
  public function destroy(string $id)
  {
    DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_OrderLocal', $id)->delete();
    DB::table('DispatcherOrder')->where('FK_Id_OrderLocal', $id)->delete();
    DB::table('OrderLocal')->where('Id_OrderLocal', $id)->delete();
    return redirect()->route('orderLocals.index')->with([
      'message' => 'Xóa đơn hàng sản xuất thành công',
      'type' => 'success',
    ]);
  }
}
