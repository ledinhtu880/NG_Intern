<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\ContentPack;
use App\Models\ContentSimple;
use App\Models\DetailContentSimpleOfPack;

class TrackingController extends Controller
{
  public function index()
  {
    if (!Session::has("type") && !Session::has("message")) {
      Session::flash('type', 'info');
      Session::flash('message', 'Trang theo dõi đơn hàng');
    }

    $data = Session::get('data');
    if (isset($data)) {
      Session::forget('data');
      return view('tracking.orders.index', compact('data'));
    }

    return view('tracking.orders.index');
  }
  public function ShowOrderByDate(Request $request)
  {
    if ($request->ajax()) {
      Session::forget('data');

      $dateAfter = $request->input('dateAfter');
      $dateBefore = $request->input('dateBefore');
      $data = DB::table('Order')
        ->leftJoin('ContentSimple AS cs', 'Id_Order', '=', 'cs.FK_Id_Order')
        ->leftJoin('ContentPack AS cp', 'Id_Order', '=', 'cp.FK_Id_Order')
        ->leftJoin('RegisterContentSimpleAtWareHouse AS rc', 'rc.FK_Id_Order', '=', 'Id_Order')
        ->leftJoin('RegisterContentPackAtWareHouse AS rp', 'rp.FK_Id_Order', '=', 'Id_Order')
        ->join('Customer AS c', 'FK_Id_Customer', '=', 'c.Id_Customer')
        ->where('Date_Order', '>=', $dateAfter)
        ->where('Date_Order', '<=', $dateBefore)
        ->select('Id_Order', 'c.Name_Customer', 'Date_Order', 'Date_Delivery', 'SimpleOrPack')
        ->selectRaw("CASE WHEN SimpleOrPack = 0 THEN COUNT(DISTINCT cs.Id_ContentSimple) + COUNT(DISTINCT rc.FK_Id_ContentSimple) ELSE COUNT(DISTINCT cp.Id_ContentPack) + COUNT(DISTINCT rp.FK_Id_ContentPack) END AS TotalCount")
        ->groupBy('Id_Order', 'c.Name_Customer', 'Date_Order', 'Date_Delivery', 'SimpleOrPack')
        ->orderBy('Date_Order', 'asc')
        ->orderBy('Id_Order', 'asc')
        ->get();

      foreach ($data as $each) {
        $countTotal = $each->TotalCount;
        $completePercent = 0;
        $percent = 0;
        if ($each->SimpleOrPack == 0) {
          $simples = DB::table('ContentSimple as cs')
            ->where('cs.FK_Id_Order', '=', $each->Id_Order)
            ->groupBy('cs.Id_ContentSimple')
            ->select('cs.Id_ContentSimple')
            ->union(
              DB::table('ContentSimple')
                ->select('Id_ContentSimple')
                ->join('RegisterContentSimpleAtWareHouse', 'ContentSimple.Id_ContentSimple', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
                ->join('Order', 'RegisterContentSimpleAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
                ->where('Order.Id_Order', $each->Id_Order)
            )
            ->pluck('Id_ContentSimple')
            ->toArray();

          foreach ($simples as $simple) {
            $isSimpleInPack = DB::table('DetailContentSimpleOfPack')->where('FK_Id_ContentSimple', $simple)->exists();
            if ($isSimpleInPack) {
              $result = DB::table('ContentSimple AS cs')
                ->join('DetailContentSimpleOrderLocal AS dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
                ->join('DispatcherOrder AS do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
                ->join('DetailProductionStationLine AS dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
                ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple GROUP BY FK_Id_ContentSimple) AS pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
                ->whereIn('cs.Id_ContentSimple', function ($query) use ($simple) {
                  $query->select('FK_Id_ContentSimple')
                    ->from('DetailContentSimpleOfPack')
                    ->where('FK_Id_ContentSimple', $simple)
                    ->limit(1);
                })
                ->groupBy('do.FK_Id_ProdStationLine')
                ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) AS TotalStation'))
                ->unionAll(function ($query) use ($simple) {
                  $query->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) AS TotalStation'))
                    ->from('ContentPack AS cs')
                    ->join('DetailContentPackOrderLocal AS dcso', 'cs.Id_ContentPack', '=', 'dcso.FK_Id_ContentPack')
                    ->join('DispatcherOrder AS do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
                    ->join('DetailProductionStationLine AS dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
                    ->leftJoin('DetailContentSimpleOfPack AS dcsop', 'cs.Id_ContentPack', '=', 'dcsop.FK_Id_ContentPack')
                    ->leftJoin('ContentSimple AS csimple', 'dcsop.FK_Id_ContentSimple', '=', 'csimple.Id_ContentSimple')
                    ->whereIn('cs.Id_ContentPack', function ($subquery) use ($simple) {
                      $subquery->select('FK_Id_ContentPack')
                        ->from('DetailContentSimpleOfPack')
                        ->where('FK_Id_ContentSimple', $simple)
                        ->limit(1);
                    })
                    ->groupBy('do.FK_Id_ProdStationLine');
                })
                ->get();
            } else {
              $result = DB::table('ContentSimple as cs')
                ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
                ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
                ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
                ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
                ->where('cs.Id_ContentSimple', '=', $simple)
                ->groupBy('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine')
                ->select('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) AS TotalStation'))
                ->get();
            }

            if ($result->count() == 0) {
              $percent = 0;
            } else if ($result->count() == 1) {
              $result = $result->first();

              $totalStation = $result->TotalStation;
              $stationComplete = DB::table('ProcessContentSimple')
                ->where('FK_Id_ContentSimple', $simple)
                ->where('FK_Id_State', 2)
                ->whereNotNull('Date_Fin')
                ->count();
              $percent = ($stationComplete / $totalStation) * 100;
            } else if ($result->count() > 1) {
              $prodStationLines = $result->pluck('FK_Id_ProdStationLine')->unique()->toArray();

              $stationArr = DB::table('DetailProductionStationLine')
                ->whereIn('FK_Id_ProdStationLine', $prodStationLines)
                ->groupBy('FK_Id_Station')
                ->pluck('FK_Id_Station')
                ->toArray();

              $totalStation = Count($stationArr);
              $stationComplete = DB::table('ProcessContentSimple')
                ->where('FK_Id_ContentSimple', $simple)
                ->where('FK_Id_State', 2)
                ->whereNotNull('Date_Fin')
                ->count();
              $percent = ($stationComplete / $totalStation) * 100;
            }
            $completePercent += $percent;
          }
        } else {
          $packs = DB::table('ContentPack as cs')
            ->where('cs.FK_Id_Order', '=', $each->Id_Order)
            ->groupBy('cs.Id_ContentPack')
            ->select('cs.Id_ContentPack')
            ->union(
              DB::table('ContentPack')
                ->select('Id_ContentPack')
                ->join('RegisterContentPackAtWareHouse', 'ContentPack.Id_ContentPack', '=', 'RegisterContentPackAtWareHouse.FK_Id_ContentPack')
                ->join('Order', 'RegisterContentPackAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
                ->where('Order.Id_Order', $each->Id_Order)
            )
            ->pluck('Id_ContentPack')
            ->toArray();
          $totalSimplePerecent = 0;
          foreach ($packs as $pack) {
            $percent = 0;
            $resultContentSimple = DB::table('ContentSimple as cs')
              ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
              ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
              ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
              ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
              ->whereIn('cs.Id_ContentSimple', function ($query) use ($pack) {
                $query->select(DB::raw('FK_Id_ContentSimple'))
                  ->from('DetailContentSimpleOfPack')
                  ->where('FK_Id_ContentPack', $pack);
              })
              ->groupBy('do.FK_Id_ProdStationLine')
              ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) AS TotalStation'));

            $resultContentPack = DB::table('ContentPack as cs')
              ->join('DetailContentPackOrderLocal as dcso', 'cs.Id_ContentPack', '=', 'dcso.FK_Id_ContentPack')
              ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
              ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
              ->leftJoin('DetailContentSimpleOfPack as dcsop', 'cs.Id_ContentPack', '=', 'dcsop.FK_Id_ContentPack')
              ->leftJoin('ContentSimple as csimple', 'dcsop.FK_Id_ContentSimple', '=', 'csimple.Id_ContentSimple')
              ->where('cs.Id_ContentPack', $pack)
              ->groupBy('do.FK_Id_ProdStationLine')
              ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'));

            $result = $resultContentSimple->unionAll($resultContentPack)->get();

            if ($result->count() == 1) {
              $prodStationLine = $result->first()->FK_Id_ProdStationLine;
              $stationArr = DB::table('DetailProductionStationLine')
                ->where('FK_Id_ProdStationLine', $prodStationLine)
                ->groupBy('FK_Id_Station')
                ->pluck('FK_Id_Station')
                ->toArray();

              $stationComplete = DB::table('ProcessContentSimple')
                ->whereIn('FK_Id_ContentSimple', function ($query) use ($pack) {
                  $query->select('FK_Id_ContentSimple')
                    ->from('DetailContentSimpleOfPack')
                    ->where('FK_Id_ContentPack', $pack);
                })
                ->where('FK_Id_State', 2)
                ->whereNotNull('Date_Fin')
                ->groupBy('FK_Id_Station')
                ->pluck('FK_Id_Station')
                ->toArray();

              $percent = (Count($stationComplete) / Count($stationArr)) * 100;
            } else if ($result->count() > 1) {
              $prodStationLines = $result->pluck('FK_Id_ProdStationLine')->unique()->toArray();

              $stationArr = DB::table('DetailProductionStationLine')
                ->whereIn('FK_Id_ProdStationLine', $prodStationLines)
                ->groupBy('FK_Id_Station')
                ->pluck('FK_Id_Station')
                ->toArray();

              $stationComplete = DB::table('ProcessContentSimple')
                ->whereIn('FK_Id_ContentSimple', function ($query) use ($pack) {
                  $query->select('FK_Id_ContentSimple')
                    ->from('DetailContentSimpleOfPack')
                    ->where('FK_Id_ContentPack', $pack);
                })
                ->where('FK_Id_State', 2)
                ->whereNotNull('Date_Fin')
                ->groupBy('FK_Id_Station')
                ->pluck('FK_Id_Station')
                ->toArray();

              $key = array_search(403, $stationComplete);
              if ($key !== false) {
                array_splice($stationComplete, $key, 1);
              }

              $percent = (Count($stationComplete) / Count($stationArr)) * 100;
            }
            $totalSimplePerecent += $percent;
          }
          $completePercent = $totalSimplePerecent;
        }
        $totalPercent = $countTotal * 100;
        if ($totalPercent > 0) {
          $each->progress = (int)(($completePercent / $totalPercent) * 100);
        } else {
          $each->progress = 0;
        }
        $each->countTotal = $countTotal;
        $each->totalPercent = $totalPercent;
        $each->completePercent = $completePercent;
        $each->progress == 100 ? $each->status = 'Hoàn thành' : $each->status = 'Chưa hoàn thành';
      }
      Session::put('data', $data);

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
      ->select(
        'cp.Id_ContentPack',
        'cp.Count_Pack',
        'cp.Price_Pack',
        DB::raw('COUNT(DISTINCT dcsp.FK_Id_ContentSimple) as TotalSimple')
      )
      ->where('cp.FK_Id_Order', '=', $id)
      ->groupBy('cp.Id_ContentPack', 'cp.Count_Pack', 'cp.Price_Pack')
      ->get();

    foreach ($data as $each) {
      $countTotal = $each->TotalSimple;
      $completePercent = 0;
      $percent = 0;

      $simples = DB::table('ContentSimple')
        ->join('DetailContentSimpleOfPack', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOfPack.FK_Id_ContentSimple')
        ->where('FK_Id_ContentPack', $each->Id_ContentPack)
        ->pluck('Id_ContentSimple')->toArray();

      $resultContentSimple = DB::table('ContentSimple as cs')
        ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
        ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
        ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
        ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
        ->whereIn('cs.Id_ContentSimple', function ($query) use ($each) {
          $query->select(DB::raw('FK_Id_ContentSimple'))
            ->from('DetailContentSimpleOfPack')
            ->where('FK_Id_ContentPack', $each->Id_ContentPack);
        })
        ->groupBy('do.FK_Id_ProdStationLine')
        ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'));

      $resultContentPack = DB::table('ContentPack as cs')
        ->join('DetailContentPackOrderLocal as dcso', 'cs.Id_ContentPack', '=', 'dcso.FK_Id_ContentPack')
        ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
        ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
        ->leftJoin('DetailContentSimpleOfPack as dcsop', 'cs.Id_ContentPack', '=', 'dcsop.FK_Id_ContentPack')
        ->leftJoin('ContentSimple as csimple', 'dcsop.FK_Id_ContentSimple', '=', 'csimple.Id_ContentSimple')
        ->where('cs.Id_ContentPack', $each->Id_ContentPack)
        ->groupBy('do.FK_Id_ProdStationLine')
        ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'));

      $result = $resultContentSimple->unionAll($resultContentPack)->get();
      foreach ($simples as $simple) {
        if ($result->count() == 1) {
          $prodStationLine = $result->first()->FK_Id_ProdStationLine;
          $stationArr = DB::table('DetailProductionStationLine')
            ->where('FK_Id_ProdStationLine', $prodStationLine)
            ->groupBy('FK_Id_Station')
            ->pluck('FK_Id_Station')
            ->toArray();

          $totalStation = count($stationArr);
          $stationComplete = DB::table('ProcessContentSimple')
            ->where('FK_Id_ContentSimple', $simple)
            ->where('FK_Id_State', 2)
            ->whereNotNull('Date_Fin')
            ->pluck('FK_Id_Station')
            ->toArray();
          $percent = (Count($stationComplete) / $totalStation) * 100;
        } else if ($result->count() > 1) {
          $prodStationLines = $result->pluck('FK_Id_ProdStationLine')->unique()->toArray();

          $stationArr = DB::table('DetailProductionStationLine')
            ->whereIn('FK_Id_ProdStationLine', $prodStationLines)
            ->groupBy('FK_Id_Station')
            ->pluck('FK_Id_Station')
            ->toArray();

          $totalStation = count($stationArr);
          $stationComplete = DB::table('ProcessContentSimple')
            ->where('FK_Id_ContentSimple', $simple)
            ->where('FK_Id_State', 2)
            ->whereNotNull('Date_Fin')
            ->pluck('FK_Id_Station')
            ->toArray();
          $percent = (Count($stationComplete) / $totalStation) * 100;
        }
        $completePercent += $percent;
      }
      $totalPercent = $countTotal * 100;
      $each->progress = (int)(($completePercent / $totalPercent) * 100);
    }
    return view('tracking.orders.showPacks', compact('order', 'data'));
  }
  public function showSimples(string $id)
  {
    $order = Order::where('Id_Order', $id)->first();
    $data = DB::table('ContentSimple as cs')
      ->join('RawMaterial as rm', 'cs.FK_Id_RawMaterial', '=', 'rm.Id_RawMaterial')
      ->join('ContainerType as ct', 'cs.FK_Id_ContainerType', '=', 'ct.Id_ContainerType')
      ->where('cs.FK_Id_Order', '=', $id)
      ->groupBy('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'cs.Count_RawMaterial', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
      ->select('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'cs.Count_RawMaterial', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
      ->union(
        DB::table('ContentSimple')
          ->select(
            'Id_ContentSimple',
            'Name_RawMaterial',
            'Unit',
            'Count_RawMaterial',
            'Name_ContainerType',
            'Count_Container',
            'Price_Container'
          )
          ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'RawMaterial.Id_RawMaterial')
          ->join('ContainerType', 'ContentSimple.FK_Id_ContainerType', '=', 'ContainerType.Id_ContainerType')
          ->join('RegisterContentSimpleAtWareHouse', 'ContentSimple.Id_ContentSimple', '=', 'RegisterContentSimpleAtWareHouse.FK_Id_ContentSimple')
          ->join('Order', 'RegisterContentSimpleAtWareHouse.FK_Id_Order', '=', 'Order.Id_Order')
          ->where('Order.Id_Order', $id)
      )
      ->get();
    foreach ($data as $each) {
      $isSimpleInPack = DB::table('DetailContentSimpleOfPack')->where('FK_Id_ContentSimple', $each->Id_ContentSimple)->exists();
      if ($isSimpleInPack) {
        $result = DB::table('ContentSimple AS cs')
          ->join('DetailContentSimpleOrderLocal AS dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
          ->join('DispatcherOrder AS do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
          ->join('DetailProductionStationLine AS dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
          ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple GROUP BY FK_Id_ContentSimple) AS pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
          ->whereIn('cs.Id_ContentSimple', function ($query) use ($each) {
            $query->select('FK_Id_ContentSimple')
              ->from('DetailContentSimpleOfPack')
              ->where('FK_Id_ContentSimple', $each->Id_ContentSimple)
              ->limit(1);
          })
          ->groupBy('do.FK_Id_ProdStationLine')
          ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) AS TotalStation'))
          ->unionAll(function ($query) use ($each) {
            $query->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) AS TotalStation'))
              ->from('ContentPack AS cs')
              ->join('DetailContentPackOrderLocal AS dcso', 'cs.Id_ContentPack', '=', 'dcso.FK_Id_ContentPack')
              ->join('DispatcherOrder AS do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
              ->join('DetailProductionStationLine AS dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
              ->leftJoin('DetailContentSimpleOfPack AS dcsop', 'cs.Id_ContentPack', '=', 'dcsop.FK_Id_ContentPack')
              ->leftJoin('ContentSimple AS csimple', 'dcsop.FK_Id_ContentSimple', '=', 'csimple.Id_ContentSimple')
              ->whereIn('cs.Id_ContentPack', function ($subquery) use ($each) {
                $subquery->select('FK_Id_ContentPack')
                  ->from('DetailContentSimpleOfPack')
                  ->where('FK_Id_ContentSimple', $each->Id_ContentSimple)
                  ->limit(1);
              })
              ->groupBy('do.FK_Id_ProdStationLine');
          })
          ->get();
      } else {
        $result = DB::table('ContentSimple as cs')
          ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
          ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
          ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
          ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
          ->where('cs.Id_ContentSimple', '=', $each->Id_ContentSimple)
          ->groupBy('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine')
          ->select('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) AS TotalStation'))
          ->get();
      }

      if ($result->count() == 1) {
        $result = $result->first(); // Lấy phần tử đầu tiên nếu có nhiều hơn một kết quả

        $totalStation = $result->TotalStation;
        $countComplete = DB::table('ProcessContentSimple')
          ->where('FK_Id_ContentSimple', $each->Id_ContentSimple)
          ->where('FK_Id_State', 2)
          ->whereNotNull('Date_Fin')
          ->count();

        $percent = ($countComplete / $totalStation) * 100;
        $each->progress = (int)$percent;
      } else if ($result->count() > 1) {
        $prodStationLines = $result->pluck('FK_Id_ProdStationLine')->unique()->toArray();

        $stationArr = DB::table('DetailProductionStationLine')
          ->whereIn('FK_Id_ProdStationLine', $prodStationLines)
          ->groupBy('FK_Id_Station')
          ->pluck('FK_Id_Station')
          ->toArray();

        $totalStation = Count($stationArr);
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
    return view('tracking.orders.showSimples', compact('order', 'data'));
  }
  public function showDetailsSimple(string $id)
  {
    $simple = ContentSimple::find($id);
    $prodStationLines = DB::table('DispatcherOrder as do')
      ->join('OrderLocal as ol', 'do.FK_Id_OrderLocal', '=', 'ol.Id_OrderLocal')
      ->join('DetailContentSimpleOrderLocal as dsol', 'ol.Id_OrderLocal', '=', 'dsol.FK_Id_OrderLocal')
      ->where('dsol.FK_Id_ContentSimple', '=', $id)
      ->pluck('do.FK_Id_ProdStationLine')
      ->toArray();

    $data = DB::table('Station as s')
      ->select('st.PathImage', 's.Id_Station', 's.Name_Station', 'st.Name_StationType')
      ->join('StationType as st', 's.FK_Id_StationType', '=', 'st.Id_StationType')
      ->join('DetailProductionStationLine as dpsl', 's.Id_Station', '=', 'dpsl.FK_Id_Station')
      ->join('DispatcherOrder as do', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
      ->whereIn('do.FK_Id_ProdStationLine', $prodStationLines)
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
      $totalTime == null ? $simple->elapsedTime = 0 : $simple->elapsedTime = $totalTime->elapsedTime;
    }

    $simple->progress == 100 ? $simple->status = 'Hoàn thành' : $simple->status = 'Chưa hoàn thành';
    return view('tracking.orders.detailSimples', compact('simple', 'data'));
  }
}
