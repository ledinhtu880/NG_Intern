<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\ContentPack;
use App\Models\ContentSimple;

class TrackingController extends Controller
{
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Trang theo dõi đơn hàng');
    }
    return view('tracking.orders.index');
  }
  public function ShowOrderByDate(Request $request)
  {
    if ($request->ajax()) {
      $dateAfter = $request->input('dateAfter');
      $dateBefore = $request->input('dateBefore');
      $data = DB::table('Order')
        ->leftJoin('ContentSimple AS cs', 'Id_Order', '=', 'cs.FK_Id_Order')
        ->leftJoin('ContentPack AS cp', 'Id_Order', '=', 'cp.FK_Id_Order')
        ->join('Customer AS c', 'FK_Id_Customer', '=', 'c.Id_Customer')
        ->where('Date_Order', '>=', $dateAfter)
        ->where('Date_Order', '<=', $dateBefore)
        ->select('Id_Order', 'c.Name_Customer', 'Date_Order', 'Date_Delivery', 'SimpleOrPack')
        ->selectRaw("CASE WHEN SimpleOrPack = 0 THEN COUNT(DISTINCT cs.Id_ContentSimple) ELSE COUNT(DISTINCT cp.Id_ContentPack) END AS TotalCount")
        ->groupBy('Id_Order', 'c.Name_Customer', 'Date_Order', 'Date_Delivery', 'SimpleOrPack')
        ->get();

      foreach ($data as $each) {
        $count = $each->TotalCount;
        $countComplete = 0;
        if ($each->SimpleOrPack == 0) {
          $simples = ContentSimple::where('FK_Id_Order', $each->Id_Order)->pluck('Id_ContentSimple')->toArray();

          foreach ($simples as $simple) {
            $currentStation = DB::table('ProcessContentSimple')
              ->where('FK_Id_ContentSimple', '=', $simple)
              ->where('FK_Id_State', 2)
              ->where('Date_Fin', '!=', null)
              ->groupBy('FK_Id_ContentSimple')
              ->max('FK_Id_Station');

            $maxStation = DB::table('DetailProductionStationLine')
              ->join('DispatcherOrder', 'DispatcherOrder.FK_Id_ProdStationLine', '=', 'DetailProductionStationLine.FK_Id_ProdStationLine')
              ->join('DetailContentSimpleOrderLocal', 'DetailContentSimpleOrderLocal.FK_Id_OrderLocal', '=', 'DispatcherOrder.FK_Id_OrderLocal')
              ->join('ProcessContentSimple', 'ProcessContentSimple.FK_Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
              ->where('DetailContentSimpleOrderLocal.FK_Id_ContentSimple', '=', $simple)
              ->max('DetailProductionStationLine.FK_Id_Station');

            if ($currentStation != null && $maxStation != null && $currentStation == $maxStation) {
              $countComplete++;
            }
          }
        } else {
          $packs = ContentPack::where('FK_Id_Order', $each->Id_Order)->pluck('Id_ContentPack')->toArray();
          foreach ($packs as $pack) {
            $currentStation = DB::table('ProcessContentPack')
              ->where('FK_Id_ContentPack', '=', $pack)
              ->where('FK_Id_State', 2)
              ->where('Date_Fin', '!=', null)
              ->groupBy('FK_Id_ContentPack')
              ->max('FK_Id_Station');

            $maxStation = DB::table('DetailProductionStationLine')
              ->join('DispatcherOrder', 'DispatcherOrder.FK_Id_ProdStationLine', '=', 'DetailProductionStationLine.FK_Id_ProdStationLine')
              ->join('DetailContentPackOrderLocal', 'DetailContentPackOrderLocal.FK_Id_OrderLocal', '=', 'DispatcherOrder.FK_Id_OrderLocal')
              ->join('ProcessContentPack', 'ProcessContentPack.FK_Id_ContentPack', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
              ->where('DetailContentPackOrderLocal.FK_Id_ContentPack', '=', $pack)
              ->max('DetailProductionStationLine.FK_Id_Station');

            if ($currentStation != null && $maxStation != null && $currentStation == $maxStation) {
              $countComplete++;
            }
          }
        }/* 
        $each->currentStation = $currentStation;
        $each->maxStation = $maxStation; */
        $count == 0 ? $each->progress = 0 : $each->progress = (int)($countComplete / $count) * 100;
        $each->progress == 100 ? $each->status = 'Hoàn thành' : $each->status = 'Chưa hoàn thành';
      }
      return response()->json([
        'status' => 'success',
        'data' => $data,
      ]);
    }
  }
  public function showPacks(string $id)
  {
    $order = Order::where('Id_Order', $id)->first();
    $data = DB::table('ContentPack as cp')
      ->leftJoin('DetailContentSimpleOfPack as dcsp', 'cp.Id_ContentPack', '=', 'dcsp.FK_Id_ContentPack')
      ->select('cp.Id_ContentPack', 'cp.Count_Pack', 'cp.Price_Pack', DB::raw('COUNT(DISTINCT dcsp.FK_Id_ContentSimple) as TotalSimple'))
      ->groupBy('cp.Id_ContentPack', 'cp.Count_Pack', 'cp.Price_Pack')
      ->get();

    foreach ($data as $each) {
      $count = $each->TotalSimple;
      $countComplete = 0;

      $simples = DB::table('ContentSimple')
        ->join('DetailContentSimpleOfPack', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOfPack.FK_Id_ContentSimple')
        ->where('FK_Id_ContentPack', $each->Id_ContentPack)
        ->pluck('Id_ContentSimple')->toArray();

      foreach ($simples as $simple) {
        $currentStation = DB::table('ProcessContentSimple')
          ->where('FK_Id_ContentSimple', '=', $simple)
          ->where('FK_Id_State', 0)
          ->where('Date_Fin', '=', null)
          ->groupBy('FK_Id_ContentSimple')
          ->max('FK_Id_Station');

        $maxStation = DB::table('DetailProductionStationLine')
          ->join('DispatcherOrder', 'DispatcherOrder.FK_Id_ProdStationLine', '=', 'DetailProductionStationLine.FK_Id_ProdStationLine')
          ->join('DetailContentSimpleOrderLocal', 'DetailContentSimpleOrderLocal.FK_Id_OrderLocal', '=', 'DispatcherOrder.FK_Id_OrderLocal')
          ->join('ProcessContentSimple', 'ProcessContentSimple.FK_Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
          ->where('DetailContentSimpleOrderLocal.FK_Id_ContentSimple', '=', $simple)
          ->max('DetailProductionStationLine.FK_Id_Station');

        if ($currentStation != null && $maxStation != null && $currentStation == $maxStation) {
          $countComplete++;
        }
      }
      $each->progress = (int)($countComplete / $count) * 100;
    }
    return view('tracking.showPacks', compact('order', 'data'));
  }
  public function showSimples(string $id)
  {
    $order = Order::where('Id_Order', $id)->first();
    $data = DB::table('ContentSimple as cs')
      ->join('RawMaterial as rm', 'cs.FK_Id_RawMaterial', '=', 'rm.Id_RawMaterial')
      ->join('ContainerType as ct', 'cs.FK_Id_ContainerType', '=', 'ct.Id_ContainerType')
      ->where('cs.FK_Id_Order', '=', $id)
      ->groupBy('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
      ->select('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
      ->get();
    foreach ($data as $each) {
      $result = DB::table('ContentSimple as cs')
        ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
        ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
        ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
        ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
        ->where('cs.Id_ContentSimple', '=', $each->Id_ContentSimple)
        ->groupBy('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine')
        ->select('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine', DB::raw('COUNT(dpsl.FK_Id_Station) as TotalStation'))
        ->first();

      if ($result != null) {
        $stationArr = DB::table('DetailProductionStationLine')
          ->where('FK_Id_ProdStationLine', '=', $result->FK_Id_ProdStationLine)
          ->groupBy('FK_Id_Station')
          ->pluck('FK_Id_Station')
          ->toArray();

        $totalStation = $result->TotalStation;
        $countComplete = DB::table('ProcessContentSimple')
          ->where('FK_Id_ContentSimple', $each->Id_ContentSimple)
          ->where('FK_Id_State', 2)
          ->whereNotNull('Date_Fin')
          ->count();

        $percent = ($countComplete / $totalStation) * 100;
        $each->progress = (int)$percent;
      } else {
        $each->progress = 'Chưa có thông tin';
      }
    }

    return view('tracking.showSimples', compact('order', 'data'));
  }
  public function showDetailsSimple(string $id)
  {
    $simple = ContentSimple::find($id);
    $FK_Id_ProdStationLine = DB::table('DispatcherOrder as do')
      ->join('OrderLocal as ol', 'do.FK_Id_OrderLocal', '=', 'ol.Id_OrderLocal')
      ->join('DetailContentSimpleOrderLocal as dsol', 'ol.Id_OrderLocal', '=', 'dsol.FK_Id_OrderLocal')
      ->where('dsol.FK_Id_ContentSimple', '=', $id)
      ->value('do.FK_Id_ProdStationLine');

    $data = DB::table('Station as s')
      ->select('st.PathImage', 's.Id_Station', 's.Name_Station', 'st.Name_StationType')
      ->join('StationType as st', 's.FK_Id_StationType', '=', 'st.Id_StationType')
      ->join('DetailProductionStationLine as dpsl', 's.Id_Station', '=', 'dpsl.FK_Id_Station')
      ->join('DispatcherOrder as do', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
      ->where('do.FK_Id_ProdStationLine', '=', $FK_Id_ProdStationLine)
      ->groupBy('st.PathImage', 's.Id_Station', 's.Name_Station', 'st.Name_StationType')
      ->orderBy('s.Id_Station')
      ->get();

    $result = DB::table('ProcessContentSimple')
      ->select('FK_Id_Station', 'Date_Fin', DB::raw("CONCAT(
        FLOOR(DATEDIFF(second, Date_Start, Date_Fin) / 3600), N' giờ, ',
        FLOOR((DATEDIFF(second, Date_Start, Date_Fin) % 3600) / 60), N' phút, ',
        (DATEDIFF(second, Date_Start, Date_Fin) % 60), N' giây'
    ) as elapsedTime"))
      ->where('FK_Id_ContentSimple', '=', $id)
      ->orderBy('FK_Id_Station')
      ->get();

    $countComplete = 0;

    foreach ($data as $each) {
      $found = false;
      foreach ($result as $processSimple) {
        if ($each->Id_Station == $processSimple->FK_Id_Station) {
          if ($processSimple->Date_Fin == null) {
            $each->status = 'Chưa hoàn thành';
            $each->elapsedTime = 'Chưa hoàn thành';
          } else {
            $each->elapsedTime = $processSimple->elapsedTime;
            $each->status = 'Hoàn thành';
            $countComplete++;
          }

          $found = true;
          break;
        }
      }

      if (!$found) {
        $each->status = 'Chưa hoàn thành';
        $each->elapsedTime = 'Chưa hoàn thành';
      }
    }

    if (count($data) == 0) {
      $simple->progress = 'Thùng hàng chưa được khởi động';
    } else {
      $percent = ($countComplete / count($data)) * 100;
      $simple->progress = (int) $percent;
      $totalTime = DB::table('ProcessContentSimple')
        ->select(DB::raw("CONCAT(
          FLOOR(SUM(DATEDIFF(second, Date_Start, Date_Fin)) / 3600), N' giờ, ',
          FLOOR((SUM(DATEDIFF(second, Date_Start, Date_Fin)) % 3600) / 60), N' phút, ',
          (SUM(DATEDIFF(second, Date_Start, Date_Fin)) % 60), N' giây'
      ) as elapsedTime"))
        ->where('FK_Id_ContentSimple', $id)
        ->havingRaw('SUM(DATEDIFF(second, Date_Start, Date_Fin)) IS NOT NULL')
        ->first();

      $simple->elapsedTime = $totalTime->elapsedTime;
    }

    $simple->progress == 100 ? $simple->status = 'Hoàn thành' : $simple->status = 'Chưa hoàn thành';
    return view('tracking.detailSimples', compact('simple', 'data'));
  }
}
