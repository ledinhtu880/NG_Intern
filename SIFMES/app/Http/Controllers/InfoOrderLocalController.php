<?php

namespace App\Http\Controllers;

use App\Models\OrderLocal;
use App\Models\ContentPack;
use App\Models\ContentSimple;
use App\Models\DetailContentSimpleOfPack;
use App\Models\DetailContentSimpleOrderLocal;
use App\Models\DetailProductionStationLine;
use App\Models\ProcessContentSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class InfoOrderLocalController extends Controller
{

  public function index()
  {
    return view('tracking.orderlocals.index');
  }
  public function getInfoOrderLocal(Request $request)
  {
    $typeOrderLocal = $request->input('typeOrderLocal');
    $data = DB::table('OrderLocal')->where('MakeOrPackOrExpedition', $typeOrderLocal)->get();
    return response()->json($data);
  }
  public function showSimples(string $id)
  {
    session()->forget('MakeOrPackOrExpedition');
    $order = OrderLocal::find($id);
    $data = DB::table('ContentSimple as cs')
      ->join('RawMaterial as rm', 'cs.FK_Id_RawMaterial', '=', 'rm.Id_RawMaterial')
      ->join('ContainerType as ct', 'cs.FK_Id_ContainerType', '=', 'ct.Id_ContainerType')
      ->join('DetailContentSimpleOrderLocal as dcpol', 'dcpol.FK_Id_ContentSimple', '=', 'cs.Id_ContentSimple')
      ->where('dcpol.FK_Id_OrderLocal', '=', $id)
      ->groupBy('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'cs.Count_RawMaterial', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
      ->select('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'cs.Count_RawMaterial', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
      ->get();
    session(['MakeOrPackOrExpedition' => $order->MakeOrPackOrExpedition]);
    foreach ($data as $each) {
      if ($order->MakeOrPackOrExpedition == 0) {
        $result = DB::table('ContentSimple as cs')
          ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
          ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
          ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
          ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple
                    FROM ProcessContentSimple WHERE FK_Id_Station <= 406
                    GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
          ->where('cs.Id_ContentSimple', '=', $each->Id_ContentSimple)
          ->whereIn('do.FK_Id_ProdStationLine', function ($query) {
            $query->select('Id_ProdStationLine')
              ->from('ProductionStationLine')
              ->where('FK_Id_OrderType', '=', 0);
          })
          ->groupBy('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine')
          ->select('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'))
          ->get();
      } else if ($order->MakeOrPackOrExpedition == 2) {
        $result = DB::table('ContentSimple as cs')
          ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
          ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
          ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
          ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple
                    FROM ProcessContentSimple WHERE FK_Id_Station >= 406 AND FK_Id_Station <= 407
                    GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
          ->where('cs.Id_ContentSimple', '=', $each->Id_ContentSimple)
          ->whereIn('do.FK_Id_ProdStationLine', function ($query) {
            $query->select('Id_ProdStationLine')
              ->from('ProductionStationLine')
              ->where('FK_Id_OrderType', '=', 1);
          })
          ->groupBy('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine')
          ->select('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'))
          ->get();
      }

      if ($result->count() == 1) {
        $result = $result->first(); // Lấy phần tử đầu tiên nếu có nhiều hơn một kết quả

        $totalStation = $result->TotalStation;
        if ($order->MakeOrPackOrExpedition == 0) {
          $countComplete = DB::table('ProcessContentSimple')
            ->where('FK_Id_ContentSimple', $each->Id_ContentSimple)
            ->where('FK_Id_State', 2)
            ->where('FK_Id_Station', '<=', 406)
            ->whereNotNull('Date_Fin')
            ->count();
        } else if ($order->MakeOrPackOrExpedition == 2) {
          $countComplete = DB::table('ProcessContentSimple')
            ->where('FK_Id_ContentSimple', $each->Id_ContentSimple)
            ->where('FK_Id_State', 2)
            ->where('FK_Id_Station', '>=', 406)
            ->where('FK_Id_Station', '<=', 407)
            ->whereNotNull('Date_Fin')
            ->count();
        }

        $percent = ($countComplete / $totalStation) * 100;
        $each->result = $result;
        $each->totalStation = $totalStation;
        $each->countComplete = $countComplete;
        $each->percent = $percent;
        $each->progress = (int)$percent;
      } else {
        $each->progress = 'Chưa có thông tin';
      }
    }
    return view('tracking.orderlocals.showSimples', compact('order', 'data'));
  }
  public function showPacks(string $id)
  {
    session()->forget('MakeOrPackOrExpedition');
    $order = OrderLocal::find($id);
    if ($order->MakeOrPackOrExpedition == 0) {
      $data = DB::table('ContentSimple as cs')
        ->join('RawMaterial as rm', 'cs.FK_Id_RawMaterial', '=', 'rm.Id_RawMaterial')
        ->join('ContainerType as ct', 'cs.FK_Id_ContainerType', '=', 'ct.Id_ContainerType')
        ->join('DetailContentSimpleOrderLocal as dcpol', 'dcpol.FK_Id_ContentSimple', '=', 'cs.Id_ContentSimple')
        ->where('dcpol.FK_Id_OrderLocal', '=', $id)
        ->groupBy('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'cs.Count_RawMaterial', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
        ->select('cs.Id_ContentSimple', 'rm.Name_RawMaterial', 'rm.Unit', 'cs.Count_RawMaterial', 'ct.Name_ContainerType', 'cs.Count_Container', 'cs.Price_Container')
        ->get();
      foreach ($data as $each) {
        if ($order->MakeOrPackOrExpedition == 0) {
          $result = DB::table('ContentSimple as cs')
            ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
            ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
            ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
            ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple
                        FROM ProcessContentSimple WHERE FK_Id_Station <= 406
                        GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
            ->where('cs.Id_ContentSimple', '=', $each->Id_ContentSimple)
            ->whereIn('do.FK_Id_ProdStationLine', function ($query) {
              $query->select('Id_ProdStationLine')
                ->from('ProductionStationLine')
                ->where('FK_Id_OrderType', '=', 0);
            })
            ->groupBy('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine')
            ->select('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'))
            ->get();
        } else if ($order->MakeOrPackOrExpedition == 2) {
          $result = DB::table('ContentSimple as cs')
            ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
            ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
            ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
            ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple
                        FROM ProcessContentSimple WHERE FK_Id_Station >= 406 AND FK_Id_Station <= 407
                        GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
            ->where('cs.Id_ContentSimple', '=', $each->Id_ContentSimple)
            ->whereIn('do.FK_Id_ProdStationLine', function ($query) {
              $query->select('Id_ProdStationLine')
                ->from('ProductionStationLine')
                ->where('FK_Id_OrderType', '=', 1);
            })
            ->groupBy('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine')
            ->select('pcs.FK_Id_Station', 'do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'))
            ->get();
        }

        if ($result->count() == 1) {
          $result = $result->first(); // Lấy phần tử đầu tiên nếu có nhiều hơn một kết quả

          $totalStation = $result->TotalStation;
          $countComplete = DB::table('ProcessContentSimple')
            ->where('FK_Id_ContentSimple', $each->Id_ContentSimple)
            ->where('FK_Id_State', 2)
            ->where('FK_Id_Station', '<=', 406)
            ->whereNotNull('Date_Fin')
            ->count();

          $percent = ($countComplete / $totalStation) * 100;
          $each->result = $result;
          $each->totalStation = $totalStation;
          $each->countComplete = $countComplete;
          $each->percent = $percent;
          $each->progress = (int)$percent;
        } else {
          $each->progress = 'Chưa có thông tin';
        }
      }
      return view('tracking.orderlocals.showPacks', compact('order', 'data'));
    } else {
      $data = DB::table('ContentPack as cp')
        ->leftJoin('DetailContentSimpleOfPack as dcsp', 'cp.Id_ContentPack', '=', 'dcsp.FK_Id_ContentPack')
        ->join('DetailContentSimpleOrderLocal as dcsol', 'dcsol.FK_Id_ContentSimple', '=', 'dcsp.FK_Id_ContentSimple')
        ->join('DetailContentPackOrderLocal as dcpol', 'dcpol.FK_Id_ContentPack', '=', 'cp.Id_ContentPack')
        ->select(
          'cp.Id_ContentPack',
          'cp.Count_Pack',
          'cp.Price_Pack',
          DB::raw('COUNT(DISTINCT dcsp.FK_Id_ContentSimple) as TotalSimple')
        )
        ->where('dcpol.FK_Id_OrderLocal', '=', $id)
        ->groupBy('cp.Id_ContentPack', 'cp.Count_Pack', 'cp.Price_Pack')
        ->get();

      foreach ($data as $each) {
        $countTotal = $each->TotalSimple;
        $completePercent = 0;
        $percent = 0;

        $simples = DB::table('ContentSimple')
          ->join('RawMaterial', 'ContentSimple.FK_Id_RawMaterial', '=', 'Id_RawMaterial')
          ->join('DetailContentSimpleOfPack', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOfPack.FK_Id_ContentSimple')
          ->where('FK_Id_ContentPack', $each->Id_ContentPack)
          ->where('FK_Id_RawMaterialType', '!=', 0)
          ->pluck('Id_ContentSimple')->toArray();

        if ($order->MakeOrPackOrExpedition == 0) {
          $result = DB::table('ContentSimple as cs')
            ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
            ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
            ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
            ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple
                    WHERE FK_Id_Station <= 406 GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
            ->whereIn('cs.Id_ContentSimple', function ($query) use ($each) {
              $query->select(DB::raw('FK_Id_ContentSimple'))
                ->from('DetailContentSimpleOfPack')
                ->where('FK_Id_ContentPack', $each->Id_ContentPack);
            })
            ->groupBy('do.FK_Id_ProdStationLine')
            ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'))
            ->get();
        } else if ($order->MakeOrPackOrExpedition == 1) {
          $result = DB::table('ContentPack as cs')
            ->join('DetailContentPackOrderLocal as dcso', 'cs.Id_ContentPack', '=', 'dcso.FK_Id_ContentPack')
            ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
            ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
            ->leftJoin('DetailContentSimpleOfPack as dcsop', 'cs.Id_ContentPack', '=', 'dcsop.FK_Id_ContentPack')
            ->leftJoin('ContentSimple as csimple', 'dcsop.FK_Id_ContentSimple', '=', 'csimple.Id_ContentSimple')
            ->where('cs.Id_ContentPack', $each->Id_ContentPack)
            ->groupBy('do.FK_Id_ProdStationLine')
            ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'))
            ->get();
        } else if ($order->MakeOrPackOrExpedition == 2) {
          if ($order->SimpleOrPack == 0) {
            $resultContentSimple = DB::table('ContentSimple as cs')
              ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
              ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
              ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
              ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple 
                    WHERE FK_Id_Station >= 406 AND FK_Id_Station <= 407
                    GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
              ->whereIn('cs.Id_ContentSimple', function ($query) use ($each) {
                $query->select(DB::raw('FK_Id_ContentSimple'))
                  ->from('DetailContentSimpleOfPack')
                  ->where('FK_Id_ContentPack', $each->Id_ContentPack);
              })
              ->groupBy('do.FK_Id_ProdStationLine')
              ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'));
          } else {
            $resultContentSimple = DB::table('ContentSimple as cs')
              ->join('DetailContentSimpleOrderLocal as dcso', 'cs.Id_ContentSimple', '=', 'dcso.FK_Id_ContentSimple')
              ->join('DispatcherOrder as do', 'dcso.FK_Id_OrderLocal', '=', 'do.FK_Id_OrderLocal')
              ->join('DetailProductionStationLine as dpsl', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
              ->join(DB::raw('(SELECT MAX(FK_Id_Station) AS FK_Id_Station, FK_Id_ContentSimple FROM ProcessContentSimple 
                    WHERE FK_Id_Station >= 409 AND FK_Id_Station <= 412
                    GROUP BY FK_Id_ContentSimple) pcs'), 'cs.Id_ContentSimple', '=', 'pcs.FK_Id_ContentSimple')
              ->whereIn('cs.Id_ContentSimple', function ($query) use ($each) {
                $query->select(DB::raw('FK_Id_ContentSimple'))
                  ->from('DetailContentSimpleOfPack')
                  ->where('FK_Id_ContentPack', $each->Id_ContentPack);
              })
              ->groupBy('do.FK_Id_ProdStationLine')
              ->select('do.FK_Id_ProdStationLine', DB::raw('COUNT(DISTINCT dpsl.FK_Id_Station) as TotalStation'));
          }
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
        }
        foreach ($simples as $simple) {
          $prodStationLine = $result->first()->FK_Id_ProdStationLine;
          $stationArr = DB::table('DetailProductionStationLine')
            ->where('FK_Id_ProdStationLine', $prodStationLine)
            ->groupBy('FK_Id_Station')
            ->pluck('FK_Id_Station')
            ->toArray();

          $totalStation = count($stationArr);
          if ($order->MakeOrPackOrExpedition == 0) {
            $stationComplete = DB::table('ProcessContentSimple')
              ->where('FK_Id_ContentSimple', $simple)
              ->where('FK_Id_State', 2)
              ->where('FK_Id_Station', '>=', 401)
              ->where('FK_Id_Station', '<=', 406)
              ->whereNotNull('Date_Fin')
              ->pluck('FK_Id_Station')
              ->toArray();
          } else if ($order->MakeOrPackOrExpedition == 1) {
            $stationComplete = DB::table('ProcessContentSimple')
              ->where('FK_Id_ContentSimple', $simple)
              ->where('FK_Id_State', 2)
              ->where('FK_Id_Station', '>=', 406)
              ->where('FK_Id_Station', '<=', 409)
              ->whereNotNull('Date_Fin')
              ->pluck('FK_Id_Station')
              ->toArray();
          } else if ($order->MakeOrPackOrExpedition == 2) {
            if ($order->SimpleOrPack == 0) {
              $stationComplete = DB::table('ProcessContentSimple')
                ->where('FK_Id_ContentSimple', $simple)
                ->where('FK_Id_State', 2)
                ->where('FK_Id_Station', '>=', 406)
                ->where('FK_Id_Station', '<=', 407)
                ->whereNotNull('Date_Fin')
                ->pluck('FK_Id_Station')
                ->toArray();
            } else {
              $stationComplete = DB::table('ProcessContentSimple')
                ->where('FK_Id_ContentSimple', $simple)
                ->where('FK_Id_State', 2)
                ->where('FK_Id_Station', '>=', 409)
                ->where('FK_Id_Station', '<=', 412)
                ->whereNotNull('Date_Fin')
                ->pluck('FK_Id_Station')
                ->toArray();
            }
          }
          $percent = (Count($stationComplete) / $totalStation) * 100;
          $completePercent += $percent;
        }
        $totalPercent = $countTotal * 100;
        $each->progress = (int)(($completePercent / $totalPercent) * 100);
      }
      return view('tracking.orderlocals.showPacks', compact('order', 'data'));
    }
  }
  public function showDetailsSimple(string $id)
  {
    $simple = ContentSimple::find($id);
    $MakeOrPackOrExpedition = session('MakeOrPackOrExpedition');
    $Id_OrderLocal = DB::table('OrderLocal')
      ->join('DetailContentSimpleOrderLocal', 'Id_OrderLocal', '=', 'FK_Id_OrderLocal')
      ->where('FK_Id_ContentSimple', $id)
      ->where('MakeOrPackOrExpedition', $MakeOrPackOrExpedition)
      ->value('Id_OrderLocal');
    if ($MakeOrPackOrExpedition == 0) {
      $FK_Id_ProdStationLine = DB::table('DispatcherOrder as do')
        ->join('OrderLocal as ol', 'do.FK_Id_OrderLocal', '=', 'ol.Id_OrderLocal')
        ->join('DetailContentSimpleOrderLocal as dsol', 'ol.Id_OrderLocal', '=', 'dsol.FK_Id_OrderLocal')
        ->where('dsol.FK_Id_ContentSimple', '=', $id)
        ->whereIn('do.FK_Id_ProdStationLine', function ($query) {
          $query->select('Id_ProdStationLine')
            ->from('ProductionStationLine')
            ->where('FK_Id_OrderType', '=', 0);
        })
        ->value('do.FK_Id_ProdStationLine');
      $result = DB::table('ProcessContentSimple')
        ->select('FK_Id_Station', 'Date_Fin', DB::raw("CONCAT(
                    FLOOR(DATEDIFF(second, Date_Start, Date_Fin) / 3600), N' giờ, ',
                    FLOOR((DATEDIFF(second, Date_Start, Date_Fin) % 3600) / 60), N' phút, ',
                    (DATEDIFF(second, Date_Start, Date_Fin) % 60), N' giây') as elapsedTime"))
        ->where('FK_Id_ContentSimple', '=', $id)
        ->where('FK_Id_Station', '<=', 406)
        ->orderBy('FK_Id_Station')
        ->get();
    } else if ($MakeOrPackOrExpedition == 2) {
      $FK_Id_ProdStationLine = DB::table('DispatcherOrder as do')
        ->join('OrderLocal as ol', 'do.FK_Id_OrderLocal', '=', 'ol.Id_OrderLocal')
        ->join('DetailContentSimpleOrderLocal as dsol', 'ol.Id_OrderLocal', '=', 'dsol.FK_Id_OrderLocal')
        ->where('dsol.FK_Id_ContentSimple', '=', $id)
        ->whereIn('do.FK_Id_ProdStationLine', function ($query) {
          $query->select('Id_ProdStationLine')
            ->from('ProductionStationLine')
            ->where('FK_Id_OrderType', '=', 1);
        })
        ->value('do.FK_Id_ProdStationLine');
      $result = DB::table('ProcessContentSimple')
        ->select('FK_Id_Station', 'Date_Fin', DB::raw("CONCAT(
                    FLOOR(DATEDIFF(second, Date_Start, Date_Fin) / 3600), N' giờ, ',
                    FLOOR((DATEDIFF(second, Date_Start, Date_Fin) % 3600) / 60), N' phút, ',
                    (DATEDIFF(second, Date_Start, Date_Fin) % 60), N' giây') as elapsedTime"))
        ->where('FK_Id_ContentSimple', '=', $id)
        ->where('FK_Id_Station', '>=', 406)
        ->where('FK_Id_Station', '<=', 407)
        ->orderBy('FK_Id_Station')
        ->get();
    }
    $data = DB::table('Station as s')
      ->select('st.PathImage', 's.Id_Station', 's.Name_Station', 'st.Name_StationType')
      ->join('StationType as st', 's.FK_Id_StationType', '=', 'st.Id_StationType')
      ->join('DetailProductionStationLine as dpsl', 's.Id_Station', '=', 'dpsl.FK_Id_Station')
      ->join('DispatcherOrder as do', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
      ->where('do.FK_Id_ProdStationLine', '=', $FK_Id_ProdStationLine)
      ->groupBy('st.PathImage', 's.Id_Station', 's.Name_Station', 'st.Name_StationType')
      ->orderBy('s.Id_Station')
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
      if ($MakeOrPackOrExpedition == 0) {
        $totalTime = DB::table('ProcessContentSimple')
          ->select(DB::raw("CONCAT(
                                FLOOR(SUM(DATEDIFF(second, Date_Start, Date_Fin)) / 3600), N' giờ, ',
                                FLOOR((SUM(DATEDIFF(second, Date_Start, Date_Fin)) % 3600) / 60), N' phút, ',
                                (SUM(DATEDIFF(second, Date_Start, Date_Fin)) % 60), N' giây') as elapsedTime"))
          ->where('FK_Id_ContentSimple', $id)
          ->where('FK_Id_Station', '<=', 406)
          ->havingRaw('SUM(DATEDIFF(second, Date_Start, Date_Fin)) IS NOT NULL')
          ->first();
      } else if ($MakeOrPackOrExpedition == 2) {
        $totalTime = DB::table('ProcessContentSimple')
          ->select(DB::raw("CONCAT(
                                FLOOR(SUM(DATEDIFF(second, Date_Start, Date_Fin)) / 3600), N' giờ, ',
                                FLOOR((SUM(DATEDIFF(second, Date_Start, Date_Fin)) % 3600) / 60), N' phút, ',
                                (SUM(DATEDIFF(second, Date_Start, Date_Fin)) % 60), N' giây') as elapsedTime"))
          ->where('FK_Id_ContentSimple', $id)
          ->where('FK_Id_Station', '>=', 406)
          ->where('FK_Id_Station', '<=', 407)
          ->havingRaw('SUM(DATEDIFF(second, Date_Start, Date_Fin)) IS NOT NULL')
          ->first();
      }
      $totalTime == null ? $simple->elapsedTime = 0 : $simple->elapsedTime = $totalTime->elapsedTime;
    }

    $simple->progress == 100 ? $simple->status = 'Hoàn thành' : $simple->status = 'Chưa hoàn thành';
    return view('tracking.orderlocals.detailSimples', compact('simple', 'data', 'Id_OrderLocal'));
  }
}
