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
        $psl = DB::table('ProductionStationLine')->get();
        return view("dispatchOrders.index", compact('psl'));
    }

    public function getProductStation(Request $request)
    {
        $value = $request->input('value');
        $psl = DB::table('ProductionStationLine')->select('Description', 'Name_OrderType')
            ->join('OrderType', 'FK_Id_OrderType', '=', 'Id_OrderType')
            ->where('Id_ProdStationLine', $value)->get();
        return response()->json($psl);
    }

    public function getStatus(Request $request)
    {
        $status = $request->input('value');
        $listOrder = DB::table('OrderLocal')->where('MakeOrPackOrExpedition', $status)->whereNotIn('Id_OrderLocal', function ($query) {
            $query->select('FK_Id_OrderLocal')
                ->from('DispatcherOrder');
        })->get();
        return response()->json($listOrder);
    }

    public function store(Request $request)
    {
        $ids = $request->input('id');

        foreach ($ids as $id) {
            $stationProd = $request->input('$stationProd');
            $contentSimple = DB::table('ContentSimple')->join('DetailContentSimpleOrderLocal', 'ContentSimple.Id_SimpleContent', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
                ->join('OrderLocal', 'DetailContentSimpleOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')->where('Id_OrderLocal', $id)->get();

            $contentPack = DB::table('ContentPack')
                ->join('DetailContentPackOrderLocal', 'ContentPack.Id_PackContent', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
                ->join('OrderLocal', 'DetailContentPackOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')
                ->where('OrderLocal.Id_OrderLocal', $id)->get();
            $SimpleOrPack = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->value('SimpleOrPack');
            $status = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->value('MakeOrPackOrExpedition');
            $now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

            // echo "Đơn hàng: " . $id . ", Loại hàng: " . $SimpleOrPack . ", Trạng thái: " . $status . '<br>'; 

            DB::table('DispatcherOrder')->insert([
                'FK_Id_OrderLocal' => $id,
                'FK_Id_ProdStationLine' => $stationProd,
                'Date_Start' => $now,
                'IsFinish' => 0,
            ]);

            if ($status == 0) {
                foreach ($contentSimple as $item) {
                    DB::table('ProcessContentSimple')->insert([
                        'FK_Id_ContentSimple' => $item->Id_SimpleContent,
                        'FK_Id_Station' => 401,
                        'FK_Id_State' => 0,
                        'Data_Start' => $now,
                    ]);
                }
            } elseif ($status == 1) {
                if ($SimpleOrPack == 0) {
                    foreach ($contentSimple as $item) {
                        DB::table('ProcessContentSimple')->insert([
                            'FK_Id_ContentSimple' => $item->Id_SimpleContent,
                            'FK_Id_Station' => 407,
                            'FK_Id_State' => 0,
                            'Data_Start' => $now,
                        ]);
                    }
                } else if ($SimpleOrPack == 1) {
                    foreach ($contentPack as $item) {
                        DB::table('ProcessContentPack')->insert([
                            'FK_Id_ContentPack' => $item->Id_PackContent,
                            'FK_Id_Station' => 408,
                            'FK_Id_State' => 0,
                            'Data_Start' => $now,
                        ]);
                    }

                    DB::table('ContentPack')
                        ->join('DetailContentPackOrderLocal', 'ContentPack.Id_PackContent', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
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
                            'FK_Id_ContentSimple' => $item->Id_SimpleContent,
                            'FK_Id_Station' => 407,
                            'FK_Id_State' => 0,
                            'Data_Start' => $now,
                        ]);
                    }
                } else if ($SimpleOrPack == 1) {
                    foreach ($contentPack as $item) {
                        DB::table('ProcessContentPack')->insert([
                            'FK_Id_ContentPack' => $item->Id_PackContent,
                            'FK_Id_Station' => 410,
                            'FK_Id_State' => 0,
                            'Data_Start' => $now,
                        ]);
                    }

                    DB::table('ContentPack')
                        ->join('DetailContentPackOrderLocal', 'ContentPack.Id_PackContent', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
                        ->join('OrderLocal', 'DetailContentPackOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')
                        ->where('OrderLocal.Id_OrderLocal', $id)
                        ->update([
                            'ContentPack.HaveEilmPE' => 0
                        ]);
                }
            }
        }
    }
    public function show(Request $request)
    {
        $id = $request->input('id');
        $data = DB::table('ContentSimple')
            ->select('Name_RawMaterial', 'Count_RawMaterial', 'Name_ContainerType', 'Count_Container', 'Price_Container')
            ->join('RawMaterial', 'Id_RawMaterial', '=', 'FK_Id_RawMaterial')
            ->join('ContainerType', 'Id_ContainerType', '=', 'FK_Id_ContainerType')
            ->join('DetailContentSimpleOrderLocal', 'Id_SimpleContent', '=', 'FK_Id_ContentSimple')
            ->where('FK_Id_OrderLocal', '=', $id)
            ->get();
        dd($data);
        // return response()->json($data);
    }
}
