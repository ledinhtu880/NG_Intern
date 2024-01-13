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
use App\Models\DetailContentPackOrderLocal;

class OrderLocalController extends Controller
{
  // ! OrderLocal Makes
  public function indexMakes()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn sản xuất và giao hàng');
    }
    $data = OrderLocal::where('MakeOrPackOrExpedition', '0')->paginate(5);
    return view('orderLocals.makes.index', compact('data'));
  }
  public function createMakes()
  {
    $customerType = CustomerType::get();
    return view('orderLocals.makes.create', compact('customerType'));
  }
  public function storeMakes(Request $request)
  {
    if ($request->ajax()) {
      $rowData = $request->input('rowData');
      $dateDelivery = $request->input('dateValue');
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
        'Date_Delivery' => $dateDelivery,
        'SimpleOrPack' => $SimpleOrPack,
        'MakeOrPackOrExpedition' => '0',
        'Date_Start' => Carbon::now(),
      ]);
      foreach ($rowData as $row) {
        DB::table('DetailContentSimpleOrderLocal')->insert([
          'FK_Id_ContentSimple' => $row['Id_ContentSimple'],
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
  public function showMakes(string $id)
  {
    $orderLocal = OrderLocal::where('Id_OrderLocal', $id)->first();
    $data = DB::table('ContentSimple')
      ->select('Id_ContentSimple', 'Name_RawMaterial', 'Count_RawMaterial', 'Unit',  'Name_ContainerType', 'Count_Container', 'Price_Container')
      ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
      ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
      ->join('DetailContentSimpleOrderLocal', 'Id_ContentSimple', '=', 'FK_Id_ContentSimple')
      ->where('FK_Id_OrderLocal', '=', $id)
      ->get();
    return view('orderLocals.makes.show', compact('orderLocal', 'data'));
  }
  public function showDetail(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $data = DB::table('ContentSimple')
        ->select('Name_RawMaterial', 'Count_RawMaterial', 'Unit', 'Name_ContainerType', 'Count_Container', 'Price_Container')
        ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
        ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
        ->join('DetailContentSimpleOrderLocal', 'Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
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
      $LiquidOrSolid = $request->input('LiquidOrSolid');
      $data = DB::table('Order')
        ->join('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
        ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
        ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
        ->join('CustomerType', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.Id')
        ->join('RawMaterial', 'FK_Id_RawMaterial', '=', 'Id_RawMaterial')
        ->where('Customer.FK_Id_CustomerType', $customerType)
        ->where('ContentSimple.ContainerProvided', 0)
        ->where('ContentSimple.PedestalProvided', 0)
        ->where('ContentSimple.CoverHatProvided', 0)
        ->where('ContentSimple.RawMaterialProvided', 0)
        ->where('Order.SimpleOrPack', $SimpleOrPack)
        ->where('RawMaterial.FK_Id_RawMaterialType', $LiquidOrSolid)
        ->whereNotIn('ContentSimple.Id_ContentSimple', function ($query) {
          $query->select('FK_Id_ContentSimple')
            ->from('ProcessContentSimple');
        })
        ->whereNotIn('ContentSimple.Id_ContentSimple', function ($query) {
          $query->select('FK_Id_ContentSimple')
            ->from('DetailContentSimpleOrderLocal');
        })
        ->select(
          'Id_ContentSimple',
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
        ->join('ContentSimple', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
        ->join('Order', 'Id_Order', '=', 'FK_Id_Order')
        ->join('Customer', 'Id_Customer', '=', 'FK_Id_Customer')
        ->join('CustomerType', 'Id', '=', 'FK_Id_CustomerType')
        ->where('CustomerType.Id', $customerType)
        ->where('OrderLocal.SimpleOrPack', $simpleOrPack)
        ->groupBy('Id_OrderLocal', 'Count', 'OrderLocal.Date_Delivery', 'OrderLocal.SimpleOrPack', 'MakeOrPackOrExpedition', 'Date_Start', 'Date_Fin')
        ->select('OrderLocal.*')
        ->get();
      return response()->json([
        'status' => 'success',
        'orders' => $orders,
      ]);
    }
  }
  public function editMakes(string $id)
  {
    $orderLocal = OrderLocal::where('Id_OrderLocal', $id)->first();
    $materials = RawMaterial::get();
    $containers = ContainerType::get();
    $data = DB::table('ContentSimple')
      ->select(
        'Id_ContentSimple',
        'FK_Id_RawMaterial',
        'Name_RawMaterial',
        'Count_RawMaterial',
        'Unit',
        'FK_Id_ContainerType',
        'Name_ContainerType',
        'Count_Container',
        'Price_Container',
        'FK_Id_RawMaterialType'
      )
      ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
      ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
      ->join('DetailContentSimpleOrderLocal', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
      ->where('FK_Id_OrderLocal', '=', $id)
      ->get();
    $LiquidOrSolid = $data->first()->FK_Id_RawMaterialType;

    if (session()->has('message') && session()->has('type')) {
      // Lấy nội dung của thông báo và loại thông báo
      $message = session()->get('message');
      $type = session()->get('type');
      return view('orderLocals.makes.edit', compact('orderLocal', 'data', 'containers', 'materials', 'LiquidOrSolid'))
        ->with('type', 'success');
    }
    return view('orderLocals.makes.edit', compact('orderLocal', 'data', 'containers', 'materials', 'LiquidOrSolid'));
  }
  public function addSimple(string $id)
  {
    $orderLocal = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->first();
    $customerType = DB::table('CustomerType')
      ->join('Customer', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.ID')
      ->join('Order', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
      ->join('ContentSimple', 'ContentSimple.FK_Id_Order', '=', 'Order.Id_Order')
      ->join('DetailContentSimpleOrderLocal', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
      ->where('FK_Id_OrderLocal', $id)
      ->value('CustomerType.Id');
    $LiquidOrSolid = DB::table('RawMaterial')
      ->join('ContentSimple', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
      ->join('Order', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
      ->join('DetailContentSimpleOrderLocal', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
      ->where('FK_Id_OrderLocal', $id)
      ->value('RawMaterial.FK_Id_RawMaterialType');
    $data = DB::table('Order')
      ->join('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
      ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
      ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
      ->join('CustomerType', 'Customer.FK_Id_CustomerType', '=', 'CustomerType.Id')
      ->join('RawMaterial', 'FK_Id_RawMaterial', '=', 'Id_RawMaterial')
      ->where('Customer.FK_Id_CustomerType', $customerType)
      ->where('RawMaterial.FK_Id_RawMaterialType', $LiquidOrSolid)
      ->where('ContentSimple.ContainerProvided', 0)
      ->where('ContentSimple.PedestalProvided', 0)
      ->where('Order.SimpleOrPack', $orderLocal->SimpleOrPack)
      ->whereNotIn('ContentSimple.Id_ContentSimple', function ($query) {
        $query->select('FK_Id_ContentSimple')
          ->from('ProcessContentSimple');
      })
      ->select(
        'Id_ContentSimple',
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
          'FK_Id_ContentSimple' => $row['Id_ContentSimple'],
          'FK_Id_OrderLocal' => $id,
        ]);
      }
      $res = redirect()->route('orderLocals.makes.edit', $id)
        ->with('type', 'success')
        ->with('message', 'Thêm thùng hàng vào đơn sản xuất thành công');
      return response()->json([
        'status' => 'success',
        'url' => $res->getTargetUrl()
      ]);
    }
  }
  public function updateMakes(Request $request)
  {
    $validator = $request->validate([
      'Id_OrderLocal' => 'required',
      'Count' => 'required',
      'MakeOrPackOrExpedition' => 'required',
      'Date_Delivery' => 'required',
      'Date_Start' => 'required',
    ]);

    $Id_OrderLocal = $validator['Id_OrderLocal'];
    $Count = $validator['Count'];
    $MakeOrPackOrExpedition = $validator['MakeOrPackOrExpedition'];
    $dateDelivery = $validator['Date_Delivery'];
    $Date_Start = $validator['Date_Start'];

    DB::table('OrderLocal')->where('Id_OrderLocal', $Id_OrderLocal)->update([
      'Id_OrderLocal' => $Id_OrderLocal,
      'Count' => $Count,
      'MakeOrPackOrExpedition' => $MakeOrPackOrExpedition,
      'Date_Delivery' => $dateDelivery,
      'Date_Start' => $Date_Start,
    ]);
    return redirect()->route('orderLocals.makes.index')->with([
      'message' => 'Sửa đơn hàng sản xuất thành công',
      'type' => 'success',
    ]);
  }
  public function destroyOrderMakes(Request $request)
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
  public function destroyMakes(string $id)
  {
    DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_OrderLocal', $id)->delete();
    DB::table('DispatcherOrder')->where('FK_Id_OrderLocal', $id)->delete();
    DB::table('OrderLocal')->where('Id_OrderLocal', $id)->delete();
    return redirect()->route('orderLocals.makes.index')->with([
      'message' => 'Xóa đơn hàng sản xuất thành công',
      'type' => 'success',
    ]);
  }
  // ! OrderLocal Packs
  public function indexPacks()
  {
    return view('orderLocals.packs.index', [
      'data' => OrderLocal::where('MakeOrPackOrExpedition', 1)->paginate(5)
    ]);
  }

  public function createPacks()
  {
    return view('orderLocals.packs.create', [
      'customerType' => CustomerType::all(),
    ]);
  }

  public function showSimpleByCustomerTypePacks(Request $request)
  {
    $Id_CustomerType = $request->idCustomerType;

    $query = DB::table('Order')
      ->join('Customer', 'Order.FK_Id_Customer', '=', 'Customer.Id_Customer')
      ->join('ContentPack', 'Order.Id_Order', '=', 'ContentPack.FK_Id_Order')
      ->join('DetailContentSimpleOfPack', 'DetailContentSimpleOfPack.FK_Id_ContentPack', '=', 'ContentPack.Id_ContentPack')
      ->join('ContentSimple', 'DetailContentSimpleOfPack.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
      ->join('ProcessContentSimple', 'ProcessContentSimple.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
      ->join('DetailStateCellOfSimpleWareHouse', 'DetailStateCellOfSimpleWareHouse.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
      ->select(
        'ContentPack.Id_ContentPack',
        'Customer.Name_Customer',
        'Count_Pack',
        'Price_Pack',
        'Order.Id_Order'
      )
      ->where('SimpleOrPack', '=', 1)
      ->where('FK_Id_CustomerType', '=', $Id_CustomerType)
      ->whereNotIn('ContentSimple.Id_ContentSimple', function ($query) {
        $query->select('ContentSimple.Id_ContentSimple')
          ->from('Order')
          ->join('ContentPack', 'Order.Id_Order', '=', 'ContentPack.FK_Id_Order')
          ->join('DetailContentSimpleOfPack', 'DetailContentSimpleOfPack.FK_Id_ContentPack', '=', 'ContentPack.Id_ContentPack')
          ->join('ContentSimple', 'DetailContentSimpleOfPack.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
          ->join('ProcessContentSimple', 'ProcessContentSimple.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
          ->where('SimpleOrPack', '=', 1)
          ->where('ProcessContentSimple.FK_Id_Station', '>=', 407);
      })
      ->whereNotIn('ContentPack.Id_ContentPack', function ($query) {
        $query->select('DetailContentPackOrderLocal.FK_Id_ContentPack')
          ->from('DetailContentPackOrderLocal');
      })
      ->groupBy(
        'ContentPack.Id_ContentPack',
        'Customer.Name_Customer',
        'Count_Pack',
        'Price_Pack',
        'Order.Id_Order'
      )
      ->get();


    $htmls = '';
    foreach ($query as $item) {
      $htmls .=
        '
          <tr>
        <td class="text-center">
            <input type="checkbox" class="form-check-input checkbox-add">
        </td>
        <td class="Id_ContentPack">' . $item->Id_ContentPack . '</td>
        <td>' . $item->Id_Order . '</td>
        <td>' . $item->Name_Customer . '</td>
        <td class="text-center">' . $item->Count_Pack . '</td>
        <td class="text-center">' . $this->numberFormat($item->Price_Pack) . ' VNĐ' .
        '</td>
          </tr>
          ';
    }

    return $htmls;
  }

  public function deleteOrderLocal(string $Id_OrderLocal)
  {
    DB::table('DispatcherOrder')->where('FK_Id_OrderLocal', $Id_OrderLocal)->delete();
    // Xóa trong bảng DetailContentPackOrderLocal
    DetailContentPackOrderLocal::where('FK_Id_OrderLocal', $Id_OrderLocal)->delete();

    // Xóa trong bảng OrderLocal
    OrderLocal::find($Id_OrderLocal)->delete();

    return redirect()->route('orderLocals.packs.index')->with('type', 'success')->with('message', 'Xóa thành công');
  }

  public function storePacks(Request $request)
  {
    $Id_ContentPacks = $request->Id_ContentPacks;
    $dateDelivery = $request->Date_Delivery;
    $htmls = '';
    $orderLocal_id = DB::table('OrderLocal')
      ->max('Id_OrderLocal');
    $orderLocal_id = $orderLocal_id == null ? 0 : ++$orderLocal_id;
    $orderLocal = OrderLocal::create([
      'Id_OrderLocal' => $orderLocal_id,
      'Count' => 1,
      'Date_Delivery' => $dateDelivery,
      'SimpleOrPack' => 1,
      'MakeOrPackOrExpedition' => 1,
      'Date_Start' => now()
    ]);


    for ($i = 0; $i < count($Id_ContentPacks); $i++) {
      DetailContentPackOrderLocal::create([
        'FK_Id_OrderLocal' => $orderLocal_id,
        'FK_Id_ContentPack' => $Id_ContentPacks[$i]
      ]);
      $htmls .= $this->getOrderLocal($orderLocal);
    }

    return $htmls;
  }

  public function showPacks(Request $request)
  {
    $Id_OrderLocal = $request->id_OrderLocal;
    $res = DB::table('ContentSimple')
      ->select('Name_RawMaterial', 'Count_RawMaterial', 'Name_ContainerType', 'Count_Container', 'Price_Container', 'Unit')
      ->join('RawMaterial', 'FK_Id_RawMaterial', '=', 'Id_RawMaterial')
      ->join('ContainerType', 'FK_Id_ContainerType', '=', 'Id_ContainerType')
      ->join('DetailContentSimpleOfPack', 'FK_Id_ContentSimple', '=', 'Id_ContentSimple')
      ->join('ContentPack', 'FK_Id_ContentPack', '=', 'Id_ContentPack')
      ->join('DetailContentPackOrderLocal', 'FK_Id_ContentPack', '=', 'Id_ContentPack')
      ->where('DetailContentPackOrderLocal.FK_Id_OrderLocal', $Id_OrderLocal)
      ->get();

    $htmls = '';
    foreach ($res as $contentSimple) {
      $htmls .= '
                <tr>
                    <td>
                        ' . $contentSimple->Name_RawMaterial . '
                    </td>
                    <td>
                        ' . $contentSimple->Count_RawMaterial . '
                    </td>
                    <td>
                        ' . $contentSimple->Unit . '
                    </td>
                    <td>
                        ' . $contentSimple->Name_ContainerType . '
                    </td>
                    <td>
                        ' . $contentSimple->Count_Container . '
                    </td>
                    <td>
                        ' . $this->numberFormat($contentSimple->Price_Container) . ' VNĐ
                    </td>
                </tr>
            ';
    }
    return $htmls;
  }

  private function numberFormat($number, $decimals = 0, $decimalSeparator = ",", $thousandSeparator = ".")
  {
    $parsedNumber = floatval($number);
    $parts = explode(".", number_format($parsedNumber, $decimals, ".", ""));
    $parts[0] = preg_replace('/\B(?=(\d{3})+(?!\d))/', $thousandSeparator, $parts[0]);

    return implode($decimalSeparator, $parts);
  }

  public function deletePacks(Request $request)
  {
    $Id_OrderLocals = $request->Id_OrderLocals;

    // Xóa ở bảng DetailContentPackOrderLocal
    foreach ($Id_OrderLocals as $Id_OrderLocal) {
      DetailContentPackOrderLocal::where('FK_Id_OrderLocal', $Id_OrderLocal)->delete();
      // Xóa ở bảng OrderLocal
      OrderLocal::find($Id_OrderLocal)->delete();
    }

    $db = OrderLocal::where('SimpleOrPack', 1)
      ->where('MakeOrPackOrExpedition', 1)->get();
    return $this->getAllOrderLocal($db);
  }

  public function showOrderLocal(Request $request)
  {
    $Id_CustomerType = $request->idCustomerType;
    $result = DB::table('OrderLocal')
      ->join('DetailContentPackOrderLocal', 'Id_OrderLocal', '=', 'FK_Id_OrderLocal')
      ->join('ContentPack', 'Id_ContentPack', '=', 'FK_Id_ContentPack')
      ->join('Order', 'Id_Order', '=', 'FK_Id_Order')
      ->join('Customer', 'Id_Customer', '=', 'FK_Id_Customer')
      ->where('Customer.FK_Id_CustomerType', $Id_CustomerType)
      ->where('OrderLocal.SimpleOrPack', 1)
      ->where('MakeOrPackOrExpedition', 1)
      ->groupBy('Id_OrderLocal', 'Count', 'OrderLocal.Date_Delivery', 'OrderLocal.SimpleOrPack', 'MakeOrPackOrExpedition', 'Date_Start', 'Date_Fin')
      ->select('Id_OrderLocal', 'Count', 'OrderLocal.Date_Delivery', 'OrderLocal.SimpleOrPack', 'MakeOrPackOrExpedition', 'Date_Start', 'Date_Fin')
      ->get();
    return $this->getAllOrderLocal($result);
  }

  private function getAllOrderLocal($orderLocals)
  {
    $htmls = '';
    foreach ($orderLocals as $orderLocal) {
      $htmls .= $this->getOrderLocal($orderLocal);
    }
    return $htmls;
  }

  private function getOrderLocal($orderLocal)
  {
    $htmls = '
            <tr>
                <td class="align-middle text-center">
                    <input type="checkbox" class="form-check-input check-remove">
                </td>
                <td class="text-center Id_OrderLocal">
                ' . $orderLocal->Id_OrderLocal . ' 
                </td>
                <td class="text-center">
                ' . $orderLocal->Count . '
                </td>
                <td>Gói hàng</td>
                <td class="text-center">
                ' . \Carbon\Carbon::parse($orderLocal->Date_Delivery)->format('d/m/Y') . '
                </td>
                <td class="text-center">
                    <button type="button" class="btnShow btn btn-sm text-secondary" data-bs-toggle="modal"
                        data-bs-target="#show-' . $orderLocal->Id_OrderLocal . '"
                        data-id="' . $orderLocal->Id_OrderLocal . '">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <div class="modal fade" id="show-' . $orderLocal->Id_OrderLocal . '" tabindex="-1"
                        aria-labelledby="show-$' . $orderLocal->Id_OrderLocal . 'Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header p-2 bg-primary text-start" data-bs-theme="dark">
                                <h5 class="modal-title w-100 " id="exampleModalLabel">
                                    Thông tin chi tiết đơn hàng số ' . $orderLocal->Id_OrderLocal . '
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped m-0">
                                        <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Nguyên liệu</th>
                                            <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                                            <th class="text-center" scope="col">Đơn vị</th>
                                            <th class="text-center" scope="col">Thùng chứa</th>
                                            <th class="text-center" scope="col">Số lượng thùng chứa</th>
                                            <th class="text-center" scope="col">Đơn giá</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-simples" class="p-5" data-value="${Id_OrderLocal}">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        ';
    return $htmls;
  }
  public function showDetailsPacks(string $Id_OrderLocal)
  {
    $data = DB::table('ContentPack')
      ->select(
        'ContentPack.Id_ContentPack',
        'Count_Pack',
        'Price_Pack'
      )
      ->join('DetailContentPackOrderLocal', 'Id_ContentPack', '=', 'FK_Id_ContentPack')
      ->where('FK_Id_OrderLocal', '=', $Id_OrderLocal)
      ->get();
    return view('orderLocals.packs.show', [
      'orderLocal' => OrderLocal::find($Id_OrderLocal),
      'data' => $data
    ]);
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
        ->where('DetailContentSimpleOfPack.FK_Id_ContentPack', $id)
        ->get();
      return response()->json($data);
    }
  }

  public function showEditPacks(string $Id_OrderLocal)
  {
    $orderLocal = OrderLocal::find($Id_OrderLocal);
    $data = DB::table('ContentPack')
      ->select(
        'ContentPack.Id_ContentPack',
        'Count_Pack',
        'Price_Pack'
      )
      ->join('DetailContentPackOrderLocal', 'Id_ContentPack', '=', 'FK_Id_ContentPack')
      ->where('FK_Id_OrderLocal', '=', $Id_OrderLocal)
      ->get();
    return view('orderLocals.packs.edit', compact('orderLocal', 'data'));
  }
  public function destroyPack(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      DB::table('DetailContentPackOrderLocal')->where('FK_Id_ContentPack', $id)->delete();
      return response()->json([
        'status' => 'success'
      ]);
    }
  }
  public function updatePacks(string $Id_OrderLocal, Request $request)
  {
    $orderLocal = OrderLocal::find($Id_OrderLocal);
    $orderLocal->Date_Delivery = $request->input('Date_Delivery');
    $orderLocal->Count = $request->input('Count');
    $orderLocal->Date_Start = $request->input('Date_Start');
    $orderLocal->save();
    return redirect()->route('orderPacks.index')->with('type', 'success')->with('message', 'Sửa đơn thành công');
  }

  // ! OrderLocal Expedition
  public function indexExpedition()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Quản lý đơn giao hàng');
    }
    $data = OrderLocal::where('MakeOrPackOrExpedition', 2)->paginate(5);
    return view('orderLocals.expeditions.index', compact('data'));
  }
  public function createExpedition()
  {
    $data = OrderLocal::where('MakeOrPackOrExpedition', 2)->get();
    return view('orderLocals.expeditions.create', compact('data'));
  }
  public function showOrderByStation(Request $request)
  {
    $station = $request->input('value');
    if ($station == 406) {
      $data = DB::table('Order')
        ->join('ContentSimple', 'Order.Id_Order', '=', 'ContentSimple.FK_Id_Order')
        ->join('ProcessContentSimple', 'ProcessContentSimple.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
        ->join('DetailStateCellOfSimpleWareHouse', 'DetailStateCellOfSimpleWareHouse.FK_Id_ContentSimple', '=', 'ContentSimple.Id_ContentSimple')
        ->join('Customer', 'Customer.Id_Customer', '=', 'Order.FK_Id_Customer')
        ->where('Order.SimpleOrPack', 0)
        ->where('ProcessContentSimple.FK_Id_Station', 406)
        ->whereNotIn('ContentSimple.Id_ContentSimple', function ($query) {
          $query->select('ContentSimple.Id_ContentSimple')
            ->from('ContentSimple')
            ->join('DetailContentSimpleOrderLocal', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
            ->join('OrderLocal', 'DetailContentSimpleOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')
            ->where('OrderLocal.MakeOrPackOrExpedition', 2);
        })
        ->select('ContentSimple.Id_ContentSimple', 'Order.Id_Order', 'Customer.Name_Customer', 'ContentSimple.FK_Id_ContainerType', 'ContentSimple.Count_Container', 'ContentSimple.Price_Container')
        ->get();
    } else if ($station == 409) {
      $data = DB::table('Order')->join('ContentPack', 'Order.Id_Order', '=', 'ContentPack.FK_Id_Order')
        ->join('ProcessContentPack', 'ProcessContentPack.FK_Id_ContentPack', '=', 'ContentPack.Id_ContentPack')
        ->join('DetailStateCellOfPackWareHouse', 'DetailStateCellOfPackWareHouse.FK_Id_ContentPack', '=', 'ContentPack.Id_ContentPack')
        ->join('Customer', 'Customer.Id_Customer', '=', 'Order.FK_Id_Customer')
        ->where('Order.SimpleOrPack', 1)
        ->where('ProcessContentPack.FK_Id_Station', $station)
        ->whereNotIn('ContentPack.Id_ContentPack', function ($query) {
          $query->select('Id_ContentPack')
            ->from('ContentPack')
            ->join('DetailContentPackOrderLocal', 'Id_ContentPack', '=', 'FK_Id_ContentPack')
            ->join('OrderLocal', 'FK_Id_OrderLocal', '=', 'Id_OrderLocal')
            ->where('OrderLocal.MakeOrPackOrExpedition', 2);
        })
        ->get();
    }
    return response()->json($data);
  }

  public function storeExpedition(Request $request)
  {
    $station = $request->input('station');
    $ids = $request->input('id');
    $date = $request->input('date');
    $currentDateTime = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

    $lastId = DB::table('OrderLocal')->max('Id_OrderLocal');

    if ($station == 406) {
      DB::table('OrderLocal')->insert([
        'Id_OrderLocal' => $lastId + 1,
        'Count' => 1,
        'Date_Delivery' => $date,
        'SimpleOrPack' => 0,
        'MakeOrPackOrExpedition' => 2,
        'Date_Start' => $currentDateTime
      ]);
      foreach ($ids as $id) {
        DB::table('DetailContentSimpleOrderLocal')->insert([
          'FK_Id_OrderLocal' => $lastId + 1,
          'FK_Id_ContentSimple' => $id,
        ]);
      }
    } else if ($station == 409) {
      DB::table('OrderLocal')->insert([
        'Id_OrderLocal' => $lastId + 1,
        'Count' => 1,
        'Date_Delivery' => $date,
        'SimpleOrPack' => 1,
        'MakeOrPackOrExpedition' => 2,
        'Date_Start' => $currentDateTime
      ]);
      foreach ($ids as $id) {
        DB::table('DetailContentPackOrderLocal')->insert([
          'FK_Id_OrderLocal' => $lastId + 1,
          'FK_Id_ContentPack' => $id,
        ]);
      }
    }
  }

  public function showOrderExpeditionDetails(Request $request)
  {
    $id = $request->input('id');
    $exist = DB::table('DetailContentSimpleOrderLocal')->where('Fk_Id_OrderLocal', $id)->exists();
    if ($exist) {
      $details = DB::table('DetailContentSimpleOrderLocal')
        ->join('ContentSimple', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
        ->join('RawMaterial', 'RawMaterial.Id_RawMaterial', '=', 'ContentSimple.FK_Id_RawMaterial')
        ->where('Fk_Id_OrderLocal', $id)
        ->select('FK_Id_ContainerType', 'Name_RawMaterial', 'Count_RawMaterial', 'Unit', 'Count_Container', 'Price_Container')
        ->get();
    } else {
      $details = DB::table('ContentPack')->join('DetailContentPackOrderLocal', 'DetailContentPackOrderLocal.FK_Id_ContentPack', '=', 'ContentPack.Id_ContentPack')
        ->join('DetailContentSimpleOfPack', 'DetailContentSimpleOfPack.FK_Id_ContentPack', '=', 'ContentPack.Id_ContentPack')
        ->join('ContentSimple', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOfPack.FK_Id_ContentSimple')
        ->join('RawMaterial', 'RawMaterial.Id_RawMaterial', '=', 'ContentSimple.FK_Id_RawMaterial')
        ->where('Fk_Id_OrderLocal', $id)
        ->select('FK_Id_ContainerType', 'Name_RawMaterial', 'Count_RawMaterial', 'Unit', 'Count_Container', 'Price_Container')
        ->get();
    }
    return response()->json($details);
  }
  public function editOrderExpedition(string $id)
  {
    $orderLocal = DB::table('OrderLocal')->where('MakeOrPackOrExpedition', 2)->where('Id_OrderLocal', $id)->first();
    return view('orderLocals.expeditions.edit', compact('orderLocal'));
  }
  public function showExpeditions(string $id)
  {
    $orderLocal = OrderLocal::find($id);
    if ($orderLocal->SimpleOrPack == 0) {
      $data = DB::table('ContentSimple')
        ->select('Id_ContentSimple', 'Name_RawMaterial', 'Count_RawMaterial', 'Unit',  'Name_ContainerType', 'Count_Container', 'Price_Container')
        ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
        ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
        ->join('DetailContentSimpleOrderLocal', 'Id_ContentSimple', '=', 'FK_Id_ContentSimple')
        ->where('FK_Id_OrderLocal', '=', $id)
        ->get();
    } else {
      $data = DB::table('DetailContentSimpleOfPack')
        ->join('ContentSimple', 'DetailContentSimpleOfPack.FK_Id_ContentSimple', '=', 'Id_ContentSimple')
        ->join('ContainerType', 'FK_Id_ContainerType', '=', 'Id_ContainerType')
        ->join('RawMaterial', 'FK_Id_RawMaterial', '=', 'Id_RawMaterial')
        ->select('Id_ContentSimple', 'Name_RawMaterial', 'Count_RawMaterial', 'Unit', 'Name_ContainerType', 'Count_Container', 'Price_Container')
        ->whereIn('FK_Id_ContentPack', function ($query) use ($id) {
          $query->select('FK_Id_ContentPack')
            ->from('DetailContentPackOrderLocal')
            ->where('DetailContentPackOrderLocal.FK_Id_OrderLocal', $id);
        })
        ->get();
    }
    return view('orderLocals.expeditions.show', compact('orderLocal', 'data'));
  }
  public function updateOrderExpedition(Request $request, string $id)
  {
    $orderLocal = OrderLocal::find($id);
    $orderLocal->Date_Delivery = $request->input('Date_Delivery');
    $orderLocal->Count = $request->input('Count');
    $orderLocal->Date_Start = $request->input('Date_Start');
    $orderLocal->save();
    if ($request->input('Date_Delivery') < $request->input('Date_Start')) {
      return redirect()->back()->with('type', 'danger')->with('message', 'Ngày bất đầu phải nhỏ hơn ngày giao hàng!');
    }
    return redirect()->route('orderLocals.expeditions.index')->with('type', 'success')->with('message', 'Sửa đơn thành công');
  }
  public function deleteOrderExpedition(Request $request)
  {
    $ids = $request->input('id');
    foreach ($ids as $id) {
      $exist = DB::table('DetailContentSimpleOrderLocal')->where('Fk_Id_OrderLocal', $id)->exists();
      if ($exist) {
        DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_OrderLocal', $id)->delete();
      } else {
        DB::table('DetailContentPackOrderLocal')->where('FK_Id_OrderLocal', $id)->delete();
      }
      DB::table('OrderLocal')->where('Id_OrderLocal', $id)->delete();
    }
  }
  public function deleteOrderExpeditionByIndex(string $id)
  {
    $exist = DB::table('DetailContentSimpleOrderLocal')->where('Fk_Id_OrderLocal', $id)->exists();
    if ($exist) {
      DB::table('DetailContentSimpleOrderLocal')->where('FK_Id_OrderLocal', $id)->delete();
    } else {
      DB::table('DetailContentPackOrderLocal')->where('FK_Id_OrderLocal', $id)->delete();
    }
    DB::table('OrderLocal')->where('Id_OrderLocal', $id)->delete();
    return redirect()->back();
  }
}
