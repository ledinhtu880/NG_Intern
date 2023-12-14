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
  public function indexSimples()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn thùng hàng');
    }
    $data = Order::where('SimpleOrPack', 0)->paginate(5);
    return view('orders.simples.index', compact('data'));
  }
  public function showSimples(string $id)
  {
    $order = Order::where('Id_Order', $id)->first();
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
      ->where('FK_Id_Order', $id)
      ->get();
    return view('orders.simples.show', compact('order', 'data'));
  }
  public function createSimples()
  {
    $customers = Customer::get();
    $containers = ContainerType::get();
    $materials = RawMaterial::get();
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $information = DB::table('Order')
        ->select('FK_Id_Customer', 'Date_Order', 'Date_Dilivery', 'Date_Reception', 'Note')
        ->where('Id_Order', $id)
        ->first();
      $data = DB::table('ContentSimple')
        ->select(
          'Id_SimpleContent',
          'Name_RawMaterial',
          'Id_RawMaterial',
          'Count_RawMaterial',
          'Unit',
          'Id_ContainerType',
          'Name_ContainerType',
          'Count_Container',
          'Price_Container'
        )->join('RawMaterial', 'FK_Id_RawMaterial', '=', 'Id_RawMaterial')
        ->join('ContainerType', 'FK_Id_ContainerType', '=', 'Id_ContainerType')
        ->join('Order', 'FK_Id_Order', '=', 'Id_Order')
        ->where('FK_Id_Order', $id)
        ->get();

      /* Nguyên liệu	,Số lượng nguyên liệu,	Đơn vị	,Thùng chứa	,Số lượng thùng chứa	Đơn giá */
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
  public function storeSimples(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      foreach ($rowData as $row) {
        DB::table('ContentSimple')->insert([
          'Id_SimpleContent' => $row['Id_SimpleContent'],
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
      ->where('FK_Id_Order', $id)
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
      foreach ($rowData as $row) {
        $id = $row['Id_SimpleContent'];
        DB::table('ContentSimple')->where('Id_SimpleContent', $id)->update([
          'FK_Id_RawMaterial' => $row['FK_Id_RawMaterial'],
          'Count_RawMaterial' => $row['Count_RawMaterial'],
          'FK_Id_ContainerType' => $row['FK_Id_ContainerType'],
          'Count_Container' => $row['Count_Container'],
          'Price_Container' => $row['Price_Container'],
        ]);
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
      ->where('FK_Id_Order', $id)->pluck('Id_SimpleContent')
      ->ToArray();
    foreach ($arrID as $each) {
      DB::table('ProcessContentSimple')->where('FK_Id_ContentSimple', $each)->delete();
      DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_ContentSimple', $each)->delete();
      DB::table('DetailStateCellOfSimpleWareHouse')->where('FK_Id_SimpleContent', $each)->delete();
      DB::table('DetailContentSimpleOfPack')->where('FK_Id_SimpleContent', $each)->delete();
    }
    DB::table('ContentSimple')->where('FK_Id_Order', $id)->delete();
    DB::table('Order')->where('Id_Order', $id)->delete();
    return redirect()->route('orders.simples.index')->with([
      'message' => 'Xóa đơn hàng thành công',
      'type' => 'success',
    ]);
  }
  public function addSimple(Request $request)
  {
    if ($request->ajax()) {
      $flag = $request->input('flag');
      $formData = $request->input('formData');
      $unit = $request->input('unit');
      $data = [];
      parse_str($formData, $formDataArray);
      $formattedPrice = number_format($formDataArray['Price_Container'], 0, ',', '.') . ' VNĐ';
      $formDataArray['unit'] = $unit;
      $formDataArray['formattedPrice'] = $formattedPrice;
      $data[] = $formDataArray;

      $maxID = DB::table('ContentSimple')->max('Id_SimpleContent');

      if ($maxID === null) {
        $id = 0; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
      } else {
        $id = $maxID + 1;
      }

      if ($flag == 1) {
        $FK_Id_Order = DB::table('Order')->max('Id_Order');
        $exists = DB::table('ContentSimple')
          ->where('FK_Id_Order', $FK_Id_Order)
          ->where('FK_Id_RawMaterial', $formDataArray['FK_Id_RawMaterial'])
          ->where('FK_Id_ContainerType', $formDataArray['FK_Id_ContainerType'])
          ->exists();

        if ($exists) {
          $id_simple = DB::table('ContentSimple')
            ->where('FK_Id_Order', $FK_Id_Order)
            ->where('FK_Id_RawMaterial', $formDataArray['FK_Id_RawMaterial'])
            ->where('FK_Id_ContainerType', $formDataArray['FK_Id_ContainerType'])
            ->value('Id_SimpleContent');

          // Truy vấn để lấy giá trị hiện tại của Count_RawMaterial
          $currentRawMaterial = DB::table('ContentSimple')->where('Id_SimpleContent', $id_simple)->value('Count_RawMaterial');
          $currentContainer = DB::table('ContentSimple')->where('Id_SimpleContent', $id_simple)->value('Count_Container');

          // Tính toán giá trị mới của Count_RawMaterial
          $newCountRawMaterial = $currentRawMaterial + $formDataArray['Count_RawMaterial'];
          $newCountContainer = $currentContainer + $formDataArray['Count_Container'];

          // Thực hiện cập nhật
          DB::table('ContentSimple')->where('Id_SimpleContent', $id_simple)->update([
            'Count_RawMaterial' => $newCountRawMaterial,
            'Count_Container' => $newCountContainer,
            'Price_Container' => $formDataArray['Price_Container'],
          ]);
        } else {
          DB::table('ContentSimple')->insert([
            'Id_SimpleContent' => $id,
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
        }
      }

      return response()->json([
        'status' => 'success',
        'data' => $data,
        'formDataArray' => $formDataArray,
        'maxID' => $id,
      ]);
    }
  }
  public function deleteSimples(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      DB::table('ContentSimple')->where('Id_SimpleContent', $id)->delete();
      return response()->json([
        'status' => 'success'
      ]);
    }
  }
  public function redirectToWarehouse(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      $data = [];
      parse_str($formData, $formDataArray);

      $res = redirect()->route('orders.simples.getSimplesInWarehouse')
        ->with('data', $data);
      return response()->json([
        'status' => 'success',
        'url' => $res->getTargetUrl()
      ]);
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
  public function getSimples(Request $request)
  {
    if ($request->ajax()) {
      $idArr = $request->input('idArr');
      $FK_Id_Order = $request->input('FK_Id_Order');
      $data = [];
      foreach ($idArr as $id) {
        $each = DB::table('ContentSimple')
          ->where('Id_SimpleContent', $id)
          ->first();

        $maxID = DB::table('ContentSimple')->max('Id_SimpleContent');
        if ($maxID === null) {
          $id = 0; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
        } else {
          $id = $maxID + 1;
        }

        DB::table('ContentSimple')->insert([
          'Id_SimpleContent' => $id,
          'FK_Id_RawMaterial' => $each->FK_Id_RawMaterial,
          'Count_RawMaterial' => $each->Count_RawMaterial,
          'FK_Id_ContainerType' => $each->FK_Id_ContainerType,
          'Count_Container' => $each->Count_Container,
          'Price_Container' => $each->Price_Container,
          'FK_Id_Order' => $FK_Id_Order,
          'ContainerProvided' => 0,
          'PedestalProvided' => 0,
          'RFIDProvided' => 0,
          'RawMaterialProvided' => 0,
          'CoverHatProvided' => 0,
          'QRCodeProvided' => 0,

        ]);
      }
      $res = redirect()->route('orders.simples.create');
      return response()->json([
        'status' => 'success',
        'url' => $res->getTargetUrl(),
        'id' => $FK_Id_Order,
      ]);
    }
  }
  public function indexPacks()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn gói hàng');
    }
    $data = Order::where('SimpleOrPack', 1)->paginate(5);
    return view('orders.packs.index', compact('data'));
  }
  public function createPacks()
  {
    $customers = Customer::get();
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $information = DB::table('Order')
        ->select('FK_Id_Customer', 'Date_Order', 'Date_Dilivery', 'Date_Reception', 'Note')
        ->where('Id_Order', $id)
        ->first();
      $data = DB::table('ContentPack')->select('Id_PackContent', 'Count_Pack', 'Price_Pack')
        ->where('FK_Id_Order', $id)
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
  public function showPacks(string $Id_Order)
  {
    return view('orders.packs.show', [
      'order' => Order::find($Id_Order),
      'contentPacks' => ContentPack::where('FK_Id_Order', $Id_Order)->get()
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
  public function editPacks(string $id)
  {
    $contentPack = DB::table('ContentPack')->select('Id_PackContent', 'Count_Pack', 'Price_Pack')->where('FK_Id_Order', $id)->get();
    return view('orders.packs.edit', [
      'order' => Order::find($id),
      'customers' => Customer::all(),
      'contentPack' => $contentPack
    ]);
  }
  public function editSimpleInPack(string $Id_PackContent)
  {
    $Id_Order = DB::table('ContentPack')
      ->where('Id_PackContent', '=', $Id_PackContent)
      ->value('FK_Id_Order');
    $details = DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->get();
    $id_SimpleContents = [];
    foreach ($details as $detail) {
      $id_SimpleContents[] = $detail->FK_Id_SimpleContent;
    }
    $simpleContents = [];
    for ($i = 0; $i < count($id_SimpleContents); $i++) {
      $simpleContents[] = ContentSimple::find($id_SimpleContents[$i]);
    }
    $materials = RawMaterial::all();
    $containerTypes = ContainerType::all();
    return view('orders.packs.editSimpleInPack', compact(
      'Id_Order',
      'simpleContents',
      'materials',
      'containerTypes',
      'Id_PackContent'
    ));
  }
  public function storePacks(Request $request)
  {
    if ($request->ajax()) {
      $data = $request->input('packData');

      $lastOrderId = DB::table('ContentPack')->max('Id_PackContent');

      if ($lastOrderId === null) {
        $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
      } else {
        $id = $lastOrderId + 1;
      }

      DB::table('ContentPack')->insert([
        'Id_PackContent' => $id,
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
    $contentPack = DB::table('ContentPack')->where('FK_Id_Order', $Id_Order)->get();
    $contentSimple = DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->get();
    foreach ($contentSimple as $each) {
      $Id_ContentSimple = $each->Id_SimpleContent;
      DB::table('DetailContentSimpleOfPack')->where('FK_Id_SimpleContent', $Id_ContentSimple)->delete();
      DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_ContentSimple', $Id_ContentSimple)->delete();
    }
    DB::table('ContentPack')->where('FK_Id_Order', $Id_Order)->delete();

    $contentSimple = DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->delete();
    Order::find($Id_Order)->delete();
    return redirect()->route('orders.packs.index')->with('type', 'success')->with('message', 'Xóa đơn gói hàng thành công');
  }
  public function storeDetailContentSimpleOfPack(Request $request)
  {
    if ($request->ajax()) {
      $OrderID = $request->input('FK_Id_Order');
      $packID = $request->input('Id_PackContent');
      $IdArr = $request->input('idArr');
      foreach ($IdArr as $each) {
        DB::table('DetailContentSimpleOfPack')->insert([
          'FK_Id_SimpleContent' => $each,
          'FK_Id_PackContent' => $packID,
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
      $Id_Order = $request->input('Id_Order');
      DB::table('DetailContentSimpleOfPack')->where('FK_Id_PackContent', $id)->delete();
      DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->delete();
      DB::table('ContentPack')->where('FK_Id_Order', $Id_Order)->delete();

      return response()->json([
        'status' => 'success'
      ]);
    }
  }
  public function destroySimpleInPack(Request $request)
  {
    $Id_SimpleContent = $request->Id_SimpleContent;
    $Id_PackContent = $request->Id_PackContent;
    // Xóa dữ liệu bảng detail
    DetailContentSimpleOfPack::where('FK_Id_SimpleContent', $Id_SimpleContent)->delete();
    // Sửa giá tiền ở bảng PackContent
    $contentSimple = ContentSimple::find($Id_SimpleContent);
    $price_Container = $contentSimple->Price_Container;
    // Xóa dữ liệu bảng simpleContent
    $contentSimple->delete();
    // Tìm idpack ở trong bảng detail, nếu còn tức là bảng ContentPack vẫn còn tồn tại, nếu không còn thì xóa
    $detail = DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->get();
    $result = '';
    $contentPack = ContentPack::find($Id_PackContent);
    if ($detail->isEmpty()) {
      $Id_Order = $contentPack->FK_Id_Order;
      $contentPack->delete();
      $result = redirect()->route('orders.packs.edit', compact('Id_Order'))->with('type', 'success')->with('message', 'Xóa thùng hàng mã: ' . $Id_SimpleContent . ' thành công');
    } else {
      $price_Pack = $contentPack->Price_Pack;
      $contentPack->Price_Pack = $price_Pack - $price_Container;
      $contentPack->save();
      // return $price_Container;
      $result = redirect()->back()->with('type', 'success')->with('message', 'Xóa thùng hàng mã: ' . $Id_SimpleContent . ' thành công');
    }

    return response()->json([
      'url' => $result->getTargetUrl()
    ]);
  }
  public function updateSimpleInPack(Request $request)
  {
    $Id_PackContent = $request->idPackContent;
    $Id_SimpleContents = $request->idSimpleContents;
    $FK_Id_RawMaterials = $request->fkIdRawMaterials;
    $Count_RawMaterials = $request->countRawMaterials;
    $FK_Id_ContainerTypes = $request->fkIdContainerTypes;
    $Count_Containers = $request->countContainers;
    $Price_Containers = $request->priceContainers;

    // Sửa từng hàng của bảng ContentSimple
    for ($i = 0; $i < count($Id_SimpleContents); $i++) {
      $simpleContent = ContentSimple::find($Id_SimpleContents[$i]);
      $simpleContent->FK_Id_RawMaterial = $FK_Id_RawMaterials[$i];
      $simpleContent->Count_RawMaterial = $Count_RawMaterials[$i];
      $simpleContent->FK_Id_ContainerType = $FK_Id_ContainerTypes[$i];
      $simpleContent->Count_Container = $Count_Containers[$i];
      $simpleContent->Price_Container = $Price_Containers[$i];
      $simpleContent->save();
    }

    // Sửa lại tổng tiền ở bảng ContentPack
    $summ = 0;
    for ($i = 0; $i < count($Price_Containers); $i++) {
      $summ += $Price_Containers[$i] * $Count_Containers[$i];
    }
    $packContent = ContentPack::find($Id_PackContent);
    $packContent->Price_Pack = $summ;
    $packContent->save();
    $Id_Order = $packContent->FK_Id_Order;

    $result = redirect()->route('orders.packs.edit', ['id' => $Id_Order]);
    return response()->json([
      'url' => $result->getTargetUrl(),
    ]);
  }
  public function destroyPackContent(Request $request)
  {
    $Id_PackContent = $request->idPackContent;
    $Id_Order = $request->idOrder;

    // Lấy Id_Simplecontent
    $details = DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->get();
    $Id_SimpleContents = [];
    // Lấy các bản ghi của simplecontent có trong packcontent
    foreach ($details as $detail) {
      $Id_SimpleContents[] = $detail->FK_Id_SimpleContent;
    }
    // Xóa các bản ghi ở bảng DetailContentSimpleOfPack có liên quan tới packcontent 
    DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->delete();

    // Xóa các simplecontent liên quan
    for ($i = 0; $i < count($Id_SimpleContents); $i++) {
      ContentSimple::find($Id_SimpleContents[$i])->delete();
    }
    // Xóa bản ghi có Id_PackContent trong bảng ContentPack
    ContentPack::find($Id_PackContent)->delete();

    $res = redirect()->back()->with('type', 'success')->with('message', 'Xóa thành công');
    return response()->json([
      'url' => $res->getTargetUrl()
    ]);
  }
  public function showPacksDetails(Request $request)
  {
    $id_PackContent = $request->id_PackContent;
    $id_SimpleContents = DetailContentSimpleOfPack::where('FK_Id_PackContent', $id_PackContent)->pluck('FK_Id_SimpleContent')->toArray();

    $simpleContents = [];
    foreach ($id_SimpleContents as $id_SimpleContent) {
      $simpleContents[] = ContentSimple::find($id_SimpleContent);
    }

    $htmls = '';

    for ($i = 0; $i < count($simpleContents); $i++) {
      $htmls .= '
                <tr>
                    <td>' . $simpleContents[$i]->material->Name_RawMaterial . '</td>
                    <td>' . $simpleContents[$i]->Count_RawMaterial . '</td>
                    <td>' . $simpleContents[$i]->material->Unit . '</td>
                    <td>' . $simpleContents[$i]->type->Name_ContainerType . '</td>
                    <td>' . $simpleContents[$i]->Count_Container . '</td>
                    <td>' . number_format($simpleContents[$i]->Price_Container, 0, ',', '.') . ' VNĐ' . '</td>
                </tr>
            ';
    }
    return $htmls;
  }
  public function updatePacks(Request $request)
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
    $res = redirect()->route('orders.packs.index')->with('type', 'success')->with('message', 'Sửa thành công');
    return response()->json([
      'url' => $res->getTargetUrl()
    ]);
  }
}
