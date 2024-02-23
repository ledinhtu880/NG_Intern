<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\RawMaterial;
use App\Models\DetailContentSimpleOfPack;
use App\Models\ContentSimple;
use App\Models\ContainerType;
use App\Models\ContentPack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function storeOrder(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
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
        'Date_Delivery' => $formDataArray['Date_Delivery'],
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

      if ($request->input('SimpleOrPack') == 0) {
        parse_str($formData, $formDataArray);
      } else {
        $formDataArray = $formData;
      }

      $data[] = $formDataArray;
      DB::table('Order')->where('Id_Order', $id)->update([
        'FK_Id_Customer' => $formDataArray['FK_Id_Customer'],
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
  public function indexSimples()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn thùng hàng');
    }

    $ordersToDelete = DB::table('Order')
      ->leftJoin('ContentPack', 'Order.Id_Order', '=', 'ContentPack.FK_Id_Order')
      ->leftJoin('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
      ->leftJoin('RegisterContentSimpleAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_Order')
      ->leftJoin('RegisterContentPackAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentPackAtWareHouse.FK_Id_Order')
      ->whereNull('ContentPack.Id_ContentPack')
      ->whereNull('ContentSimple.Id_ContentSimple')
      ->whereNull('RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
      ->whereNull('RegisterContentPackAtWareHouse.FK_ID_ContentPack')
      ->pluck('Order.Id_Order');

    // Xóa các Order không có ContentPack hoặc ContentSimple
    DB::table('Order')->whereIn('Id_Order', $ordersToDelete)->delete();

    $data = Order::join('Customer', 'Id_Customer', '=', 'FK_Id_Customer')
      ->join('CustomerType', 'Id', '=', 'FK_Id_CustomerType')
      ->select('Order.*', 'CustomerType.Name')
      ->where('SimpleOrPack', 0)
      ->orderBy('Id_Order')
      ->paginate(5);

    return view('orders.simples.index', compact('data'));
  }
  public function redirectToSimples(Request $request)
  {
    if ($request->ajax()) {
      $res = redirect()->route('orders.simples.index')
        ->with('type', 'success')
        ->with('message', 'Tạo đơn thùng hàng thành công');
      return response()->json([
        'url' => $res->getTargetUrl()
      ]);
    }
  }
  public function checkSimpleInProcess(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('Id_ContentSimple');
      $flag = DB::table('ContentSimple')
        ->join('ProcessContentSimple', 'ContentSimple.Id_ContentSimple', '=', 'ProcessContentSimple.FK_Id_ContentSimple')
        ->exists();
      return response()->json($flag);
    }
  }
  public function checkPackInProcess(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('Id_ContentPack');
      $flag = DB::table('ContentPack')
        ->join('ProcessContentPack', 'ContentPack.Id_ContentPack', '=', 'ProcessContentPack.FK_Id_ContentPack')
        ->exists();
      return response()->json($flag);
    }
  }
  public function showSimples(string $id)
  {
    $order = Order::where('Id_Order', $id)->first();
    $data = DB::table('ContentSimple')
      ->select(
        'Id_ContentSimple',
        'RawMaterial.Name_RawMaterial',
        'ContentSimple.Count_RawMaterial',
        'RawMaterial.Unit',
        'ContainerType.Name_ContainerType',
        'ContentSimple.Count_Container',
        'ContentSimple.Price_Container',
        DB::raw("N'Sản xuất mới' AS Status")
      )
      ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->leftJoin('RegisterContentSimpleAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_Order')
      ->where('Order.Id_Order', $id)
      ->union(
        DB::table('ContentSimple')
          ->select(
            'Id_ContentSimple',
            'RawMaterial.Name_RawMaterial',
            'ContentSimple.Count_RawMaterial',
            'RawMaterial.Unit',
            'ContainerType.Name_ContainerType',
            'ContentSimple.Count_Container',
            'ContentSimple.Price_Container',
            DB::raw("N'Lấy từ kho' AS Status")
          )
          ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
          ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
          ->join('RegisterContentSimpleAtWareHouse', 'ContentSimple.Id_ContentSimple', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
          ->join('Order', 'RegisterContentSimpleAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
          ->where('Order.Id_Order', $id)
      )
      ->get();
    return view('orders.simples.show', compact('order', 'data'));
  }
  public function createSimples()
  {
    $customers = Customer::get();
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    if (isset($_GET['id'])) {
      if ($_GET['id'] == 'null') {
        $maxID = DB::table('ContentSimple')->max('Id_ContentSimple');
        $id = ($maxID === null) ? 1 : $maxID + 1;
      } else {
        $id = $_GET['id'];
      }
      $information = DB::table('Order')
        ->select('FK_Id_Customer', 'Date_Order', 'Date_Delivery', 'Date_Reception', 'Note')
        ->where('Id_Order', $id)
        ->first();
      $data = DB::table('ContentSimple')
        ->select(
          'Id_ContentSimple',
          'Id_RawMaterial',
          'RawMaterial.Name_RawMaterial',
          'ContentSimple.Count_RawMaterial',
          'RawMaterial.Unit',
          'Id_ContainerType',
          'ContainerType.Name_ContainerType',
          'ContentSimple.Count_Container',
          'ContentSimple.Price_Container',
          DB::raw("N'Sản xuất mới' AS Status")
        )
        ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
        ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
        ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
        ->leftJoin('RegisterContentSimpleAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_Order')
        ->where('Order.Id_Order', $id)
        ->union(
          DB::table('ContentSimple')
            ->select(
              'Id_ContentSimple',
              'Id_RawMaterial',
              'RawMaterial.Name_RawMaterial',
              'ContentSimple.Count_RawMaterial',
              'RawMaterial.Unit',
              'Id_ContainerType',
              'ContainerType.Name_ContainerType',
              'RegisterContentSimpleAtWareHouse.Count',
              'ContentSimple.Price_Container',
              DB::raw("N'Lấy từ kho' AS Status")
            )
            ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
            ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
            ->join('RegisterContentSimpleAtWareHouse', 'ContentSimple.Id_ContentSimple', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
            ->join('Order', 'RegisterContentSimpleAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
            ->where('Order.Id_Order', $id)
        )
        ->get();

      return view('orders.simples.create', [
        'customers' => $customers,
        'materials' => $materials,
        'containers' => $containers,
        'information' => $information,
        'data' => $data,
        'count' => 1,
      ]);
    }

    return view('orders.simples.create', [
      'customers' => $customers,
      'containers' => $containers,
      'materials' => $materials,
    ]);
  }
  public function destroySimplesWhenBack(Request $request)
  {
    if ($request->ajax()) {
      $maxID = DB::table('Order')->max('Id_Order');
      $id = ($maxID === null) ? 0 : $maxID;

      $simples = DB::table('ContentSimple')->where('FK_Id_Order', $id)->pluck('Id_ContentSimple');
      foreach ($simples as $each) {
        DB::table('RegisterContentSimpleAtWareHouse')->where('FK_Id_ContentSimple', $each)->delete();
      }

      DB::table('RegisterContentSimpleAtWareHouse')->where('FK_Id_Order', $id)->delete();
      DB::table('ContentSimple')->where('FK_Id_Order', $id)->delete();
      DB::table('Order')->where('Id_Order', $id)->delete();

      return response()->json([
        'status' => 'success',
        'id' => $id
      ]);
    }
  }
  public function updateSimplesWhenSave(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      parse_str($formData, $formDataArray);
      $lastOrderId = DB::table('Order')->max('Id_Order');
      DB::table('Order')->where('Id_Order', $lastOrderId)->update([
        'FK_Id_Customer' => $formDataArray['FK_Id_Customer'],
        'Date_Order' => $formDataArray['Date_Order'],
        'Date_Delivery' => $formDataArray['Date_Delivery'],
        'Date_Reception' => $formDataArray['Date_Reception'],
        'Note' => $formDataArray['Note'],
        'SimpleOrPack' => $formDataArray['SimpleOrPack'],
      ]);
      return response()->json($formDataArray);
    }
  }
  public function storeSimples(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      foreach ($rowData as $row) {
        DB::table('ContentSimple')->insert([
          'Id_ContentSimple' => $row['Id_ContentSimple'],
          'FK_Id_RawMaterial' => $row['FK_Id_RawMaterial'],
          'Count_RawMaterial' => $row['Count_RawMaterial'],
          'FK_Id_ContainerType' => $row['FK_Id_ContainerType'],
          'Count_Container' => $row['Count_Container'],
          'Price_Container' => $row['Price_Container'],
          'FK_Id_Order' => $row['FK_Id_Order'],
          'ContainerProvided' => 0,
          'PedestalProvided' => 0,
          'RFIDProvided' => 0,
          'RawMaterialProvided' => 0,
          'CoverHatProvided' => 0,
          'QRCodeProvided' => 0,
        ]);
      }
      $res = redirect()->route('orders.simples.index')
        ->with('type', 'success')
        ->with('message', 'Tạo đơn hàng thành công');
      return response()->json([
        'url' => $res->getTargetUrl()
      ]);
    }
  }
  public function editSimples(string $id)
  {
    $order = Order::where('Id_Order', $id)->first();

    $customers = Customer::get();
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    $data = DB::table('ContentSimple')
      ->select(
        'Id_ContentSimple',
        'FK_Id_RawMaterial',
        'RawMaterial.Name_RawMaterial',
        'ContentSimple.Count_RawMaterial',
        'RawMaterial.Unit',
        'FK_Id_ContainerType',
        'ContainerType.Name_ContainerType',
        'ContentSimple.Count_Container',
        'ContentSimple.Price_Container',
        DB::raw("N'Sản xuất mới' AS Status")
      )
      ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->leftJoin('RegisterContentSimpleAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_Order')
      ->where('Order.Id_Order', $id)
      ->union(
        DB::table('ContentSimple')
          ->select(
            'Id_ContentSimple',
            'FK_Id_RawMaterial',
            'RawMaterial.Name_RawMaterial',
            'ContentSimple.Count_RawMaterial',
            'RawMaterial.Unit',
            'FK_Id_ContainerType',
            'ContainerType.Name_ContainerType',
            'RegisterContentSimpleAtWareHouse.Count',
            'ContentSimple.Price_Container',
            DB::raw("N'Lấy từ kho' AS Status")
          )
          ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
          ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
          ->join('RegisterContentSimpleAtWareHouse', 'ContentSimple.Id_ContentSimple', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
          ->join('Order', 'RegisterContentSimpleAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
          ->where('Order.Id_Order', $id)
      )
      ->get();

    return view('orders.simples.edit', [
      'order' => $order,
      'customers' => $customers,
      'containers' => $containers,
      'materials' => $materials,
      'data' => $data,
    ]);
  }
  public function updateSimples(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      $id = $request->input('id');
      foreach ($rowData as $row) {
        if ($row['Status'] == 0) {
          DB::table('ContentSimple')->where('Id_ContentSimple', $row['Id_ContentSimple'])->update([
            'FK_Id_RawMaterial' => $row['FK_Id_RawMaterial'],
            'Count_RawMaterial' => $row['Count_RawMaterial'],
            'FK_Id_ContainerType' => $row['FK_Id_ContainerType'],
            'Count_Container' => $row['Count_Container'],
            'Price_Container' => $row['Price_Container'],
          ]);
        } else if ($row['Status'] == 1) {
          $result = DB::table('ContentSimple')
            ->selectRaw('(ContentSimple.Count_Container - COALESCE(SUM(RegisterContentSimpleAtWareHouse.Count), 0)) as SoLuong')
            ->join('DetailStateCellOfSimpleWareHouse', 'DetailStateCellOfSimpleWareHouse.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
            ->leftJoin('RegisterContentSimpleAtWareHouse', 'ContentSimple.Id_ContentSimple', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
            ->where('ContentSimple.Id_ContentSimple', '=', $row['Id_ContentSimple'])
            ->groupBy('Count_RawMaterial', 'Count_Container', 'Price_Container')
            ->first();

          $soLuongCu = DB::table('RegisterContentSimpleAtWareHouse')
            ->where('FK_Id_ContentSimple', $row['Id_ContentSimple'])
            ->where('FK_Id_Order', $id)
            ->value('Count');

          $soLuongThayDoi = (int)$row['Count_Container'] - (int)$soLuongCu;
          if ($soLuongThayDoi == $result->SoLuong) {
            DB::table('DetailStateCellOfSimpleWareHouse')
              ->where('FK_Id_ContentSimple', '=', $row['Id_ContentSimple'])
              ->update([
                'FK_Id_ContentSimple' => null,
                'FK_Id_StateCell' => 1,
              ]);
          }
          DB::table('RegisterContentSimpleAtWareHouse')->where('FK_Id_ContentSimple', $row['Id_ContentSimple'])->update([
            'Count' => $row['Count_Container'],
          ]);
        }
      }
      $res = redirect()->route('orders.simples.index')
        ->with('type', 'success')
        ->with('message', 'Sửa đơn hàng thành công');
      return response()->json([
        'url' => $res->getTargetUrl()
      ]);
    }
  }
  public function destroySimples(string $id)
  {
    $arrID = DB::table('ContentSimple')
      ->where('FK_Id_Order', $id)->pluck('Id_ContentSimple')
      ->toArray();

    foreach ($arrID as $each) {
      $exists = DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_ContentSimple', $each)->exists();
      if ($exists) {
        return redirect()->route('orders.simples.index')->with([
          'message' => 'Không thể xóa do đơn hàng đã được khởi động.',
          'type' => 'warning',
        ]);
      }
    }

    DB::table('ContentSimple')->where('FK_Id_Order', $id)->delete();
    DB::table('RegisterContentSimpleAtWareHouse')->where('FK_Id_Order', $id)->delete();
    DB::table('RegisterContentPackAtWareHouse')->where('FK_Id_Order', $id)->delete();
    DB::table('Order')->where('Id_Order', $id)->delete();

    return redirect()->route('orders.simples.index')->with([
      'message' => 'Xóa đơn hàng thành công.',
      'type' => 'success',
    ]);
  }
  public function addSimple(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      $unit = $request->input('unit');
      $data = [];
      parse_str($formData, $formDataArray);
      $price = $formDataArray['Price_Container'];
      $formattedPrice = number_format($price, ($price == (int)$price) ? 0 : 2, ',', '.') . ' VNĐ';
      $formDataArray['unit'] = $unit;
      $formDataArray['formattedPrice'] = $formattedPrice;

      $FK_Id_Order = DB::table('Order')->max('Id_Order');

      $existingRow = DB::table('ContentSimple')
        ->where('FK_Id_Order', $FK_Id_Order)
        ->where('FK_Id_RawMaterial', $formDataArray['FK_Id_RawMaterial'])
        ->where('FK_Id_ContainerType', $formDataArray['FK_Id_ContainerType'])
        ->where('Price_Container', $formDataArray['Price_Container'])
        ->first();

      if ($existingRow) {
        // Cập nhật số lượng dòng dữ liệu đã tồn tại
        $id_simple = $existingRow->Id_ContentSimple;
        $currentCountRawMaterial = $existingRow->Count_RawMaterial;
        $currentCountContainer = $existingRow->Count_Container;

        $newCountRawMaterial = $currentCountRawMaterial + $formDataArray['Count_RawMaterial'];
        $newCountContainer = $currentCountContainer + $formDataArray['Count_Container'];

        $existsData['Id_ContentSimple'] = $existingRow->Id_ContentSimple;
        $existsData['Count_RawMaterial'] = $newCountRawMaterial;
        $existsData['Count_Container'] = $newCountContainer;

        $data[] = $existsData;

        DB::table('ContentSimple')->where('Id_ContentSimple', $id_simple)->update([
          'Count_RawMaterial' => $newCountRawMaterial,
          'Count_Container' => $newCountContainer,
          'Price_Container' => $formDataArray['Price_Container'],
        ]);

        return response()->json([
          'status' => 'success',
          'existsData' => $existsData,
          'exists' => 1
        ]);
      } else {
        $data[] = $formDataArray;

        // Thêm dòng dữ liệu mới
        $maxID = DB::table('ContentSimple')->max('Id_ContentSimple');
        $id = ($maxID === null) ? 0 : $maxID + 1;

        DB::table('ContentSimple')->insert([
          'Id_ContentSimple' => $id,
          'FK_Id_RawMaterial' => $formDataArray['FK_Id_RawMaterial'],
          'Count_RawMaterial' => $formDataArray['Count_RawMaterial'],
          'FK_Id_ContainerType' => $formDataArray['FK_Id_ContainerType'],
          'Count_Container' => $formDataArray['Count_Container'],
          'Price_Container' => $formDataArray['Price_Container'],
          'FK_Id_Order' => $FK_Id_Order,
          'ContainerProvided' => 0,
          'PedestalProvided' => 0,
          'RFIDProvided' => 0,
          'RawMaterialProvided' => 0,
          'CoverHatProvided' => 0,
          'QRCodeProvided' => 0,
        ]);

        return response()->json([
          'status' => 'success',
          'data' => $data,
          'maxID' => $id,
          'exists' => 0
        ]);
      }
    }
  }
  public function deleteSimples(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $isTake = $request->input('isTake');
      $isDispatcher = false;

      if ($isTake) {
        DB::table('RegisterContentSimpleAtWareHouse')->where('FK_Id_ContentSimple', $id)->delete();
      } else {
        $exists = DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_ContentSimple', $id)->exists();
        if ($exists) {
          $isDispatcher = true;
          return response()->json($isDispatcher);
        } else {
          DB::table('ContentSimple')->where('Id_ContentSimple', $id)->delete();
        }
      }
      return response()->json($isDispatcher);
    }
  }
  public function getSimplesInWarehouse()
  {
    if (session()->has('data')) {
      // Lấy nội dung của thông báo và loại thông báo
      $data = session()->get('data');

      return view('orders.simples.warehouse', [
        'data' => $data,
      ]);
    }
    return view('orders.simples.warehouse');
  }
  public function checkCustomer(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $SimpleOrPack = $request->input('SimpleOrPack');
      if ($SimpleOrPack == 0) {
        $flag = DB::table('ContentSimple')
          ->join('Order', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
          ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
          ->join('CustomerType', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.Id')
          ->where('Id_ContentSimple', $id)
          ->value('CustomerType.ID');
      } else {
        $flag = DB::table('ContentPack')
          ->join('Order', 'ContentPack.FK_Id_Order', '=', 'Order.Id_Order')
          ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
          ->join('CustomerType', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.Id')
          ->where('Id_ContentPack', $id)
          ->value('CustomerType.ID');
      }
      return response()->json([
        'status' => 'success',
        'flag' => $flag
      ]);
    }
  }
  public function getSimple(Request $request)
  {
    if ($request->ajax()) {
      $dataArr = $request->input('dataArr');
      $FK_Id_Order = $request->input('FK_Id_Order');
      if ($FK_Id_Order == 'null') {
        $maxID = DB::table('ContentSimple')->max('Id_ContentSimple');
        $FK_Id_Order = ($maxID === null) ? 1 : $maxID + 1;
      }
      foreach ($dataArr as $each) {
        $existingRecord = DB::table('RegisterContentSimpleAtWareHouse')
          ->where('FK_Id_ContentSimple', $each['id'])
          ->where('FK_Id_Order', $FK_Id_Order)
          ->first();
        if ($existingRecord) {
          // Cập nhật dữ liệu nếu đã tồn tại
          DB::table('RegisterContentSimpleAtWareHouse')
            ->where('FK_Id_ContentSimple', $each['id'])
            ->where('FK_Id_Order', $FK_Id_Order)
            ->update(['Count' => (int)$existingRecord->Count + (int)$each['Count']]);
        } else {
          // Chèn dữ liệu mới nếu chưa tồn tại
          DB::table('RegisterContentSimpleAtWareHouse')->insert(
            [
              'FK_Id_ContentSimple' => $each['id'],
              'FK_Id_Order' => $FK_Id_Order,
              'Count' => $each['Count'],
            ]
          );
        }
      }
      $res = redirect()->route('orders.simples.create');
      return response()->json([
        'status' => 'success',
        'url' => $res->getTargetUrl(),
        'id' => $FK_Id_Order,
      ]);
    }
  }
  // cho de chat GPT cai...
  public function indexPacks()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn gói hàng');
    }
    $maxID = DB::table('Order')->max('Id_Order');

    $ordersToDelete = DB::table('Order')
      ->leftJoin('ContentPack', 'Order.Id_Order', '=', 'ContentPack.FK_Id_Order')
      ->leftJoin('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
      ->leftJoin('RegisterContentSimpleAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_Order')
      ->leftJoin('RegisterContentPackAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentPackAtWareHouse.FK_Id_Order')
      ->whereNull('ContentPack.Id_ContentPack')
      ->whereNull('ContentSimple.Id_ContentSimple')
      ->whereNull('RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
      ->whereNull('RegisterContentPackAtWareHouse.FK_ID_ContentPack')
      ->pluck('Order.Id_Order');

    // Xóa các Order không có ContentPack hoặc ContentSimple
    DB::table('Order')->whereIn('Id_Order', $ordersToDelete)->delete();

    $data = Order::join('Customer', 'Id_Customer', '=', 'FK_Id_Customer')
      ->join('CustomerType', 'Id', '=', 'FK_Id_CustomerType')
      ->select('Order.*', 'CustomerType.Name')
      ->orderBy('Id_Order')
      ->where('SimpleOrPack', 1)->paginate(5);
    return view('orders.packs.index', compact('data'));
  }
  public function createPacks()
  {
    $customers = Customer::get();
    if (isset($_GET['id'])) {
      $id = $_GET['id'];

      $information = DB::table('Order')
        ->select('FK_Id_Customer', 'Date_Order', 'Date_Delivery', 'Date_Reception', 'Note')
        ->where('Id_Order', $id)
        ->first();
      $data = DB::table('ContentPack')
        ->select(
          'Id_ContentPack',
          'Count_Pack',
          'Price_Pack',
          DB::raw("N'Sản xuất mới' AS Status")
        )
        ->join('Order', 'ContentPack.FK_Id_Order', '=', 'Order.Id_Order')
        ->leftJoin('RegisterContentPackAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentPackAtWareHouse.FK_Id_Order')
        ->where('Order.Id_Order', $id)
        ->union(
          DB::table('ContentPack')
            ->select(
              'Id_ContentPack',
              'RegisterContentPackAtWareHouse.Count',
              'Price_Pack',
              DB::raw("N'Lấy từ kho' AS Status")
            )
            ->join('RegisterContentPackAtWareHouse', 'ContentPack.Id_ContentPack', '=', 'RegisterContentPackAtWareHouse.FK_Id_ContentPack')
            ->join('Order', 'RegisterContentPackAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
            ->where('Order.Id_Order', $id)
        )
        ->get();
      return view('orders.packs.create', [
        'customers' => $customers,
        'information' => $information,
        'data' => $data,
        'count' => 1,
      ]);
    } else {
      return view('orders.packs.create', [
        'customers' => $customers,
      ]);
    }
  }
  public function destroyPacksWhenBack(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $packs = DB::table('ContentPack')->where('FK_Id_Order', $id)->pluck('Id_ContentPack');

      foreach ($packs as $each) {
        DB::table('DetailContentSimpleOfPack')->where('FK_Id_ContentPack', $each)->delete();
        DB::table('RegisterContentPackAtWareHouse')->where('FK_Id_ContentPack', $each)->delete();
      }

      DB::table('RegisterContentPackAtWareHouse')->where('FK_Id_Order', $id)->delete();
      DB::table('ContentPack')->where('FK_Id_Order', $id)->delete();
      DB::table('ContentSimple')->where('FK_Id_Order', $id)->delete();

      return response()->json([
        'status' => 'success'
      ]);
    }
  }
  public function showPacks(string $Id_Order)
  {
    $data = DB::table('ContentPack')
      ->select(
        'Id_ContentPack',
        'Count_Pack',
        'Price_Pack',
        DB::raw("N'Sản xuất mới' AS Status")
      )
      ->join('Order', 'ContentPack.FK_Id_Order', '=', 'Order.Id_Order')
      ->leftJoin('RegisterContentPackAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentPackAtWareHouse.FK_Id_Order')
      ->where('Order.Id_Order', $Id_Order)
      ->union(
        DB::table('ContentPack')
          ->select(
            'Id_ContentPack',
            'RegisterContentPackAtWareHouse.Count',
            'Price_Pack',
            DB::raw("N'Lấy từ kho' AS Status")
          )
          ->join('RegisterContentPackAtWareHouse', 'ContentPack.Id_ContentPack', '=', 'RegisterContentPackAtWareHouse.FK_Id_ContentPack')
          ->join('Order', 'RegisterContentPackAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
          ->where('Order.Id_Order', $Id_Order)
      )
      ->get();
    return view('orders.packs.show', [
      'order' => Order::find($Id_Order),
      'contentPacks' => $data,
    ]);
  }
  public function createSimpleToPack()
  {
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    return view('orders.packs.createSimpleToPack', [
      'containers' => $containers,
      'materials' => $materials,
    ]);
  }
  public function addSimpleToPack(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $formData = $request->input('formData');
      $unit = $request->input('unit');
      $data = [];
      parse_str($formData, $formDataArray);
      $price = $formDataArray['Price_Container'];
      $formattedPrice = number_format($price, ($price == (int)$price) ? 0 : 2, ',', '.') . ' VNĐ';
      $formDataArray['unit'] = $unit;
      $formDataArray['formattedPrice'] = $formattedPrice;

      $FK_Id_Order = DB::table('Order')->max('Id_Order');

      $existingRow = DB::table('ContentSimple')
        ->leftJoin('DetailContentSimpleOfPack', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOfPack.FK_Id_ContentSimple')
        ->where('ContentSimple.FK_Id_Order', $FK_Id_Order)
        ->where('ContentSimple.FK_Id_RawMaterial', $formDataArray['FK_Id_RawMaterial'])
        ->where('ContentSimple.FK_Id_ContainerType', $formDataArray['FK_Id_ContainerType'])
        ->where('ContentSimple.Price_Container', $formDataArray['Price_Container'])
        ->whereNull('DetailContentSimpleOfPack.FK_Id_ContentSimple')
        ->first();

      if ($existingRow) {
        // Cập nhật số lượng dòng dữ liệu đã tồn tại
        $id_simple = $existingRow->Id_ContentSimple;
        $currentCountRawMaterial = $existingRow->Count_RawMaterial;
        $currentCountContainer = $existingRow->Count_Container;

        $newCountRawMaterial = $currentCountRawMaterial + $formDataArray['Count_RawMaterial'];
        $newCountContainer = $currentCountContainer + $formDataArray['Count_Container'];

        $existsData['Id_ContentSimple'] = $existingRow->Id_ContentSimple;
        $existsData['Count_RawMaterial'] = $newCountRawMaterial;
        $existsData['Count_Container'] = $newCountContainer;

        $data[] = $existsData;

        DB::table('ContentSimple')->where('Id_ContentSimple', $id_simple)->update([
          'Count_RawMaterial' => $newCountRawMaterial,
          'Count_Container' => $newCountContainer,
          'Price_Container' => $formDataArray['Price_Container'],
        ]);

        return response()->json([
          'status' => 'success',
          'existsData' => $existsData,
          'exists' => 1
        ]);
      } else {
        $data[] = $formDataArray;

        // Thêm dòng dữ liệu mới
        $maxID = DB::table('ContentSimple')->max('Id_ContentSimple');
        $id = ($maxID === null) ? 0 : $maxID + 1;

        DB::table('ContentSimple')->insert([
          'Id_ContentSimple' => $id,
          'FK_Id_RawMaterial' => $formDataArray['FK_Id_RawMaterial'],
          'Count_RawMaterial' => $formDataArray['Count_RawMaterial'],
          'FK_Id_ContainerType' => $formDataArray['FK_Id_ContainerType'],
          'Count_Container' => $formDataArray['Count_Container'],
          'Price_Container' => $formDataArray['Price_Container'],
          'FK_Id_Order' => $FK_Id_Order,
          'ContainerProvided' => 0,
          'PedestalProvided' => 0,
          'RFIDProvided' => 0,
          'RawMaterialProvided' => 0,
          'CoverHatProvided' => 0,
          'QRCodeProvided' => 0,
        ]);

        return response()->json([
          'status' => 'success',
          'data' => $data,
          'maxID' => $id,
          'exists' => 0
        ]);
      }
    }
  }
  public function getPacksInWarehouse()
  {
    if (session()->has('data')) {
      // Lấy nội dung của thông báo và loại thông báo
      $data = session()->get('data');

      return view('orders.packs.warehouse', [
        'data' => $data,
      ]);
    }
    return view('orders.packs.warehouse');
  }
  public function getPack(Request $request)
  {
    if ($request->ajax()) {
      $dataArr = $request->input('dataArr');
      $FK_Id_Order = $request->input('FK_Id_Order');
      foreach ($dataArr as $each) {
        $existingRecord = DB::table('RegisterContentPackAtWareHouse')
          ->where('FK_ID_ContentPack', $each['id'])
          ->where('FK_Id_Order', $FK_Id_Order)
          ->first();

        if ($existingRecord) {
          // Cập nhật dữ liệu nếu đã tồn tại
          DB::table('RegisterContentPackAtWareHouse')
            ->where('FK_ID_ContentPack', $each['id'])
            ->where('FK_Id_Order', $FK_Id_Order)
            ->update(['Count' => $existingRecord->Count + $each['Count']]);
        } else {
          // Chèn dữ liệu mới nếu chưa tồn tại
          DB::table('RegisterContentPackAtWareHouse')->insert(
            [
              'FK_ID_ContentPack' => $each['id'],
              'FK_Id_Order' => $FK_Id_Order,
              'Count' => $each['Count'],
            ]
          );
        }
      }
      $res = redirect()->route('orders.packs.create');
      return response()->json([
        'status' => 'success',
        'url' => $res->getTargetUrl(),
        'id' => $FK_Id_Order,
      ]);
    }
  }
  public function editPacks(string $id)
  {
    $contentPack = DB::table('ContentPack')
      ->select(
        'Id_ContentPack',
        'Count_Pack',
        'Price_Pack',
        DB::raw("N'Sản xuất mới' AS Status")
      )
      ->join('Order', 'ContentPack.FK_Id_Order', '=', 'Order.Id_Order')
      ->leftJoin('RegisterContentPackAtWareHouse', 'Order.Id_Order', '=', 'RegisterContentPackAtWareHouse.FK_Id_Order')
      ->where('Order.Id_Order', $id)
      ->union(
        DB::table('ContentPack')
          ->select(
            'Id_ContentPack',
            'RegisterContentPackAtWareHouse.Count',
            'Price_Pack',
            DB::raw("N'Lấy từ kho' AS Status")
          )
          ->join('RegisterContentPackAtWareHouse', 'ContentPack.Id_ContentPack', '=', 'RegisterContentPackAtWareHouse.FK_Id_ContentPack')
          ->join('Order', 'RegisterContentPackAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
          ->where('Order.Id_Order', $id)
      )
      ->get();
    return view('orders.packs.edit', [
      'order' => Order::find($id),
      'customers' => Customer::all(),
      'contentPack' => $contentPack
    ]);
  }
  public function editSimpleInPack(string $Id_ContentPack)
  {
    $Id_Order = DB::table('ContentPack')
      ->where('Id_ContentPack', '=', $Id_ContentPack)
      ->value('FK_Id_Order');
    $details = DetailContentSimpleOfPack::where('FK_Id_ContentPack', $Id_ContentPack)->get();
    $id_ContentSimples = [];
    foreach ($details as $detail) {
      $id_ContentSimples[] = $detail->FK_Id_ContentSimple;
    }
    $ContentSimples = [];
    for ($i = 0; $i < count($id_ContentSimples); $i++) {
      $ContentSimples[] = ContentSimple::find($id_ContentSimples[$i]);
    }
    $materials = RawMaterial::all();
    $containerTypes = ContainerType::all();
    return view('orders.packs.editSimpleInPack', compact(
      'Id_Order',
      'ContentSimples',
      'materials',
      'containerTypes',
      'Id_ContentPack'
    ));
  }
  public function storePacks(Request $request)
  {
    if ($request->ajax()) {
      $data = $request->input('packData');

      $lastOrderId = DB::table('ContentPack')->max('Id_ContentPack');

      if ($lastOrderId === null) {
        $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
      } else {
        $id = $lastOrderId + 1;
      }

      DB::table('ContentPack')->insert([
        'Id_ContentPack' => $id,
        'Count_Pack' => $data['Count_Pack'],
        'Price_Pack' => $data['Price_Pack'],
        'FK_Id_Order' => $data['FK_Id_Order'],
        'HaveEilmPE' => 0,
        'HaveNFC' => 0,
      ]);

      return response()->json([
        'status' => 'success',
        'id' => $id,
      ]);
    }
  }
  public function destroyPacks(string $Id_Order)
  {
    // Xóa dữ liệu ở bảng DetailContentSimpleOfPack trước
    $contentSimple = DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->get();
    foreach ($contentSimple as $each) {
      $exists = DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_ContentSimple', $each->Id_ContentSimple)->exists();
      if ($exists) {
        return redirect()->route('orders.simples.index')->with([
          'message' => 'Không thể xóa do đơn hàng đã được khởi động.',
          'type' => 'warning',
        ]);
      }
      DB::table('DetailContentSimpleOfPack')->where('FK_Id_ContentSimple', $each->Id_ContentSimple)->delete();
    }

    DB::table('RegisterContentPackAtWareHouse')->where('FK_Id_Order', $Id_Order)->delete();
    DB::table('ContentPack')->where('FK_Id_Order', $Id_Order)->delete();
    DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->delete();
    DB::table('Order')->where('Id_Order', $Id_Order)->delete();
    return redirect()->route('orders.packs.index')->with('type', 'success')->with('message', 'Xóa đơn gói hàng thành công');
  }
  public function storeDetailContentSimpleOfPack(Request $request)
  {
    if ($request->ajax()) {
      $OrderID = $request->input('FK_Id_Order');
      $packID = $request->input('Id_ContentPack');
      $IdArr = $request->input('idArr');
      foreach ($IdArr as $each) {
        DB::table('DetailContentSimpleOfPack')->insert([
          'FK_Id_ContentSimple' => $each,
          'FK_Id_ContentPack' => $packID,
        ]);
      }

      return response()->json([
        'status' => 'success',
        'id' => $OrderID
      ]);
    }
  }
  public function deletePacks(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $simples = DB::table('DetailContentSimpleOfPack')->where('FK_Id_ContentPack', $id)->get();

      DB::table('DetailContentSimpleOfPack')->where('FK_Id_ContentPack', $id)->delete();

      foreach ($simples as $each) {
        DB::table('ContentSimple')
          ->where('Id_ContentSimple', $each->FK_Id_ContentSimple)
          ->delete();
      }
      DB::table('ContentPack')->where('Id_ContentPack', $id)->delete();

      return response()->json([
        'status' => 'success',
        'simples' => $simples
      ]);
    }
  }
  public function destroySimpleInPack(Request $request)
  {
    $Id_ContentSimple = $request->Id_ContentSimple;
    $Id_ContentPack = $request->Id_ContentPack;
    // Xóa dữ liệu bảng detail
    DetailContentSimpleOfPack::where('FK_Id_ContentSimple', $Id_ContentSimple)->delete();
    // Sửa giá tiền ở bảng ContentPack
    $contentSimple = ContentSimple::find($Id_ContentSimple);
    $price_Container = $contentSimple->Price_Container;
    // Xóa dữ liệu bảng ContentSimple
    $contentSimple->delete();
    // Tìm idpack ở trong bảng detail, nếu còn tức là bảng ContentPack vẫn còn tồn tại, nếu không còn thì xóa
    $detail = DetailContentSimpleOfPack::where('FK_Id_ContentPack', $Id_ContentPack)->get();
    $result = '';
    $contentPack = ContentPack::find($Id_ContentPack);
    if ($detail->isEmpty()) {
      $Id_Order = $contentPack->FK_Id_Order;
      $contentPack->delete();
      $result = redirect()->route('orders.packs.edit', compact('Id_Order'))->with('type', 'success')->with('message', 'Xóa thùng hàng mã: ' . $Id_ContentSimple . ' thành công');
    } else {
      $price_Pack = $contentPack->Price_Pack;
      $contentPack->Price_Pack = $price_Pack - $price_Container;
      $contentPack->save();
      // return $price_Container;
      $result = redirect()->back()->with('type', 'success')->with('message', 'Xóa thùng hàng mã: ' . $Id_ContentSimple . ' thành công');
    }

    return response()->json([
      'url' => $result->getTargetUrl()
    ]);
  }
  public function updateSimpleInPack(Request $request)
  {
    $Id_ContentPack = $request->idContentPack;
    $Id_ContentSimples = $request->idContentSimples;
    $FK_Id_RawMaterials = $request->fkIdRawMaterials;
    $Count_RawMaterials = $request->countRawMaterials;
    $FK_Id_ContainerTypes = $request->fkIdContainerTypes;
    $Count_Containers = $request->countContainers;
    $Price_Containers = $request->priceContainers;

    // Sửa từng hàng của bảng ContentSimple
    for ($i = 0; $i < count($Id_ContentSimples); $i++) {
      $ContentSimple = ContentSimple::find($Id_ContentSimples[$i]);
      $ContentSimple->FK_Id_RawMaterial = $FK_Id_RawMaterials[$i];
      $ContentSimple->Count_RawMaterial = $Count_RawMaterials[$i];
      $ContentSimple->FK_Id_ContainerType = $FK_Id_ContainerTypes[$i];
      $ContentSimple->Count_Container = $Count_Containers[$i];
      $ContentSimple->Price_Container = $Price_Containers[$i];
      $ContentSimple->save();
    }

    // Sửa lại tổng tiền ở bảng ContentPack
    $summ = 0;
    for ($i = 0; $i < count($Price_Containers); $i++) {
      $summ += $Price_Containers[$i] * $Count_Containers[$i];
    }
    $ContentPack = ContentPack::find($Id_ContentPack);
    $ContentPack->Price_Pack = $summ;
    $ContentPack->save();
    $Id_Order = $ContentPack->FK_Id_Order;

    $result = redirect()->route('orders.packs.edit', ['id' => $Id_Order]);
    return response()->json([
      'url' => $result->getTargetUrl(),
    ]);
  }
  public function destroyContentPack(Request $request)
  {
    if ($request->ajax()) {
      $Id_ContentPack = $request->input('idContentPack');
      $isTake = $request->input('isTake');

      $details = DetailContentSimpleOfPack::where('FK_Id_ContentPack', $Id_ContentPack)->get();

      if ($isTake == 1) {
        DB::table('RegisterContentPackAtWareHouse')->where('FK_Id_ContentPack', $Id_ContentPack)->delete();
      } else {
        // Xóa các bản ghi ở bảng DetailContentSimpleOfPack có liên quan tới ContentPack 
        DetailContentSimpleOfPack::where('FK_Id_ContentPack', $Id_ContentPack)->delete();

        foreach ($details as $detail) {
          DB::table('ContentSimple')->where('Id_ContentSimple', $detail->FK_Id_ContentSimple)->delete();
        }

        // Xóa bản ghi có Id_ContentPack trong bảng ContentPack
        ContentPack::find($Id_ContentPack)->delete();
      }

      return response()->json([
        'status' => 'success'
      ]);
    }
  }
  public function showPacksDetails(Request $request)
  {
    $id_ContentPack = $request->id_ContentPack;
    $id_ContentSimples = DetailContentSimpleOfPack::where('FK_Id_ContentPack', $id_ContentPack)->pluck('FK_Id_ContentSimple')->toArray();

    $ContentSimples = [];
    foreach ($id_ContentSimples as $id_ContentSimple) {
      $ContentSimples[] = ContentSimple::find($id_ContentSimple);
    }

    $htmls = '';

    for ($i = 0; $i < count($ContentSimples); $i++) {
      $htmls .= '
                <tr>
                    <td>' . $ContentSimples[$i]->material->Name_RawMaterial . '</td>
                    <td>' . $ContentSimples[$i]->Count_RawMaterial . '</td>
                    <td>' . $ContentSimples[$i]->material->Unit . '</td>
                    <td>' . $ContentSimples[$i]->type->Name_ContainerType . '</td>
                    <td>' . $ContentSimples[$i]->Count_Container . '</td>
                    <td>' . number_format($ContentSimples[$i]->Price_Container, ($ContentSimples[$i]->Price_Container == (int)$ContentSimples[$i]->Price_Container) ? 0 : 2, ',', '.') . ' VNĐ' . '</td>
                </tr>
            ';
    }
    return $htmls;
  }
  public function updatePacks(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');

      $Id_ContentPacks = $request->input('idContentPacks');
      $Count_Packs = $request->input('countPacks');
      $data = [];
      for ($i = 0; $i < count($Id_ContentPacks); $i++) {
        $check = DB::table('ContentPack')
          ->where('FK_Id_Order', $id)
          ->where('Id_ContentPack', $Id_ContentPacks[$i])
          ->exists();
        if ($check) {
          DB::table('ContentPack')->where('Id_ContentPack', $Id_ContentPacks[$i])->update([
            'Count_Pack' => $Count_Packs[$i]
          ]);
        } else {
          $result = DB::table('ContentPack')
            ->selectRaw('(Count_Pack - COALESCE(SUM(RegisterContentPackAtWareHouse.Count), 0)) as SoLuong')
            ->leftJoin('RegisterContentPackAtWareHouse', 'Id_ContentPack', '=', 'FK_Id_ContentPack')
            ->where('Id_ContentPack', '=', $Id_ContentPacks[$i])
            ->groupBy('Id_ContentPack', 'Count_Pack', 'Price_Pack')
            ->first();

          $soLuongCu = DB::table('RegisterContentPackAtWareHouse')
            ->where('FK_Id_ContentPack', $Id_ContentPacks[$i])
            ->where('FK_Id_Order', $id)
            ->value('Count');

          $soLuongThayDoi = $Count_Packs[$i] - (int)$soLuongCu;
          if ($soLuongThayDoi == $result->SoLuong) {
            DB::table('DetailStateCellOfPackWareHouse')
              ->where('FK_Id_ContentPack', '=', (int)$Id_ContentPacks[$i])
              ->update([
                'FK_Id_ContentPack' => null,
                'FK_Id_StateCell' => 1,
              ]);
          }
          DB::table('RegisterContentPackAtWareHouse')->where('FK_Id_ContentPack', $Id_ContentPacks[$i])->update([
            'Count' => $Count_Packs[$i]
          ]);
        }
      }
      $res = redirect()->route('orders.packs.index')->with('type', 'success')->with('message', 'Sửa gói hàng thành công');
      return response()->json([
        'url' => $res->getTargetUrl()
      ]);
    }
  }
}
