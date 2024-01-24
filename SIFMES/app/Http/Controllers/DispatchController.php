<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderLocal;
use Illuminate\Support\Carbon;


class DispatchController extends Controller
{
    public function index()
    {
        $raw_type = DB::table('RawMaterialType')->whereIn('Id_RawMaterialType', [1, 2])->get();
        $psl = DB::table('ProductionStationLine')->get();
        return view("dispatchOrders.index", compact('psl', 'raw_type'));
    }

    public function getProductStation(Request $request)
    {
        $value = $request->input('value');
        $psl = DB::table('ProductionStationLine')->select('Description', 'Name_OrderType')
            ->join('OrderType', 'FK_Id_OrderType', '=', 'Id_OrderType')
            ->where('Id_ProdStationLine', $value)->get();
        return response()->json($psl);
    }

    public function getProductStationByRaw(Request $request)
    {
        $raw_type = $request->input('raw_type');
        if ($raw_type == 0) {
            $psl = DB::table('ProductionStationLine')->select('Id_ProdStationLine', 'Name_ProdStationLine', 'Description', 'Name_OrderType')
                ->join('OrderType', 'FK_Id_OrderType', '=', 'Id_OrderType')
                ->where('Id_ProdStationLine', 0)->first();
            return response()->json($psl);
        } else if ($raw_type == 1) {
            $psl = DB::table('ProductionStationLine')->select('Id_ProdStationLine', 'Name_ProdStationLine', 'Description', 'Name_OrderType')
                ->join('OrderType', 'FK_Id_OrderType', '=', 'Id_OrderType')
                ->where('Id_ProdStationLine', 1)->first();
            return response()->json($psl);
        }
    }

    public function getStatus(Request $request)
    {
        $status = $request->input('value');
        $listOrder = DB::table('OrderLocal')
            ->where('MakeOrPackOrExpedition', $status)
            ->whereNotIn('Id_OrderLocal', function ($query) {
                $query->select('FK_Id_OrderLocal')
                    ->from('DispatcherOrder');
            })
            ->get();
        if ($status == 1) {
            $status_name = "Đóng gói";
        } else if ($status == 2) {
            $status_name = "Giao";
        }
        $psl = DB::table('ProductionStationLine')->select('Id_ProdStationLine', 'Name_ProdStationLine', 'Description', 'Name_OrderType')
            ->join('OrderType', 'FK_Id_OrderType', '=', 'Id_OrderType')
            ->where('Name_ProdStationLine', 'LIKE', '%' . $status_name . '%')->get();
        return response()->json([
            'orderlocals' => $listOrder,
            'psl' => $psl
        ]);
    }

    public function getOrderlocalsByRawType(Request $request)
    {
        $id_type = $request->input('id_type');
        if ($id_type == 1) {
            $psl = DB::table('ProductionStationLine')->select('Id_ProdStationLine', 'Name_ProdStationLine', 'Description')
                ->join('OrderType', 'FK_Id_OrderType', '=', 'Id_OrderType')
                ->where('Id_ProdStationLine', 0)->get();
        } else if ($id_type == 2) {
            $psl = DB::table('ProductionStationLine')->select('Id_ProdStationLine', 'Name_ProdStationLine', 'Description')
                ->join('OrderType', 'FK_Id_OrderType', '=', 'Id_OrderType')
                ->where('Id_ProdStationLine', 1)->get();
        }

        $orderlocals = DB::table('DetailContentSimpleOrderLocal as DL')
            ->join('OrderLocal as O', 'O.Id_OrderLocal', '=', 'DL.FK_Id_OrderLocal')
            ->join('ContentSimple as C', 'DL.FK_Id_ContentSimple', '=', 'C.Id_ContentSimple')
            ->join('RawMaterial as R', 'R.Id_RawMaterial', '=', 'C.FK_Id_RawMaterial')
            ->where('R.FK_Id_RawMaterialType', $id_type)
            ->where('O.MakeOrPackOrExpedition', 0)
            ->select('O.*')->distinct()
            ->whereNotIn('Id_OrderLocal', function ($query) {
                $query->select('FK_Id_OrderLocal')
                    ->from('DispatcherOrder');
            })
            ->get();
        return response()->json([
            'orderlocals' => $orderlocals,
            'psl' => $psl
        ]);
    }

    public function store(Request $request)
    {
        $ids = $request->input('id');

        foreach ($ids as $id) {
            $stationProd = $request->input('$stationProd');
            $contentSimple =
                DB::table('ContentSimple')
                ->join('DetailContentSimpleOrderLocal', 'ContentSimple.Id_ContentSimple', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
                ->join('OrderLocal', 'DetailContentSimpleOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')->where('Id_OrderLocal', $id)->get();
            $contentPack = DB::table('ContentPack')
                ->join('DetailContentPackOrderLocal', 'ContentPack.Id_ContentPack', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
                ->join('OrderLocal', 'DetailContentPackOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')
                ->where('OrderLocal.Id_OrderLocal', $id)->get();
            $SimpleOrPack = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->value('SimpleOrPack');
            $status = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->value('MakeOrPackOrExpedition');
            $now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

            DB::table('DispatcherOrder')->insert([
                'FK_Id_OrderLocal' => $id,
                'FK_Id_ProdStationLine' => $stationProd,
                'Date_Start' => $now,
                'IsFinish' => 0,
            ]);

            if ($status == 0) {
                foreach ($contentSimple as $item) {
                    DB::table('ProcessContentSimple')->insert([
                        'FK_Id_ContentSimple' => $item->Id_ContentSimple,
                        'FK_Id_Station' => 401,
                        'FK_Id_State' => 0,
                        'Date_Start' => $now,
                    ]);
                }
            } elseif ($status == 1) {
                if ($SimpleOrPack == 0) {
                    foreach ($contentSimple as $item) {
                        DB::table('ProcessContentSimple')->insert([
                            'FK_Id_ContentSimple' => $item->Id_ContentSimple,
                            'FK_Id_Station' => 407,
                            'FK_Id_State' => 0,
                            'Date_Start' => $now,
                        ]);
                    }
                } else if ($SimpleOrPack == 1) {
                    foreach ($contentPack as $item) {
                        DB::table('ProcessContentPack')->insert([
                            'FK_Id_ContentPack' => $item->Id_ContentPack,
                            'FK_Id_Station' => 408,
                            'FK_Id_State' => 0,
                            'Date_Start' => $now,
                        ]);
                    }

                    $contentSimples = DB::table('DetailContentSimpleOfPack')
                        ->select('FK_Id_ContentSimple')
                        ->whereIn('FK_Id_ContentPack', function ($query) use ($id) {
                            $query->select('FK_Id_ContentPack')
                                ->from('DetailContentPackOrderLocal')
                                ->where('FK_Id_OrderLocal', $id);
                        })
                        ->get();
                    foreach ($contentSimples as $item) {
                        DB::table('ProcessContentSimple')->insert([
                            'FK_Id_ContentSimple' => $item->FK_Id_ContentSimple,
                            'FK_Id_Station' => 408,
                            'FK_Id_State' => 0,
                            'Date_Start' => $now,
                        ]);
                    }

                    DB::table('ContentPack')
                        ->join('DetailContentPackOrderLocal', 'ContentPack.Id_ContentPack', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
                        ->join('OrderLocal', 'DetailContentPackOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')
                        ->where('OrderLocal.Id_OrderLocal', $id)
                        ->update([
                            'ContentPack.HaveEilmPE' => 0
                        ]);
                }
            } elseif ($status == 2) {
                if ($SimpleOrPack == 0) {
                    foreach ($contentSimple as $item) {
                        DB::table('ProcessContentSimple')->insert([
                            'FK_Id_ContentSimple' => $item->Id_ContentSimple,
                            'FK_Id_Station' => 407,
                            'FK_Id_State' => 0,
                            'Date_Start' => $now,
                        ]);
                    }
                } else if ($SimpleOrPack == 1) {
                    foreach ($contentPack as $item) {
                        DB::table('ProcessContentPack')->insert([
                            'FK_Id_ContentPack' => $item->Id_ContentPack,
                            'FK_Id_Station' => 410,
                            'FK_Id_State' => 0,
                            'Date_Start' => $now,
                        ]);
                    }
                    $contentSimples = DB::table('DetailContentSimpleOfPack')
                        ->select('FK_Id_ContentSimple')
                        ->whereIn('FK_Id_ContentPack', function ($query) use ($id) {
                            $query->select('FK_Id_ContentPack')
                                ->from('DetailContentPackOrderLocal')
                                ->where('FK_Id_OrderLocal', $id);
                        })
                        ->get();
                    foreach ($contentSimples as $item) {
                        DB::table('ProcessContentSimple')->insert([
                            'FK_Id_ContentSimple' => $item->FK_Id_ContentSimple,
                            'FK_Id_Station' => 410,
                            'FK_Id_State' => 0,
                            'Date_Start' => $now,
                        ]);
                    }

                    DB::table('ContentPack')
                        ->join('DetailContentPackOrderLocal', 'ContentPack.Id_ContentPack', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
                        ->join('OrderLocal', 'DetailContentPackOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')
                        ->where('OrderLocal.Id_OrderLocal', $id)
                        ->update([
                            'ContentPack.HaveEilmPE' => 0
                        ]);
                }
            }
        }
    }
}
