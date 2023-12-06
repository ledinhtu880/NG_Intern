<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderLocal;
use Illuminate\Support\Carbon;

class DispatchController extends Controller
{
    //
    public function index()
    {
        $psl = DB::table('ProductionStationLine')->get();
        $listOrder = OrderLocal::all();
        $type = DB::table('OrderType')->get();

        return view("dispatchOrders.index", compact('listOrder', 'psl', 'type'));
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
        $listOrder = DB::table('OrderLocal')->where('MakeOrPackOrExpedition', $status)->get();
        return response()->json($listOrder);
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $stationProd = $request->input('station');
        $contentSimple = DB::table('ContentSimple')->join('DetailContentSimpleOrderLocal', 'ContentSimple.Id_SimpleContent', '=', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
            ->join('OrderLocal', 'DetailContentSimpleOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')->where('Id_OrderLocal', $id)->get();
        $contentPack = DB::table('ContentPack')->join('DetailContentPackOrderLocal', 'ContentPack.Id_PackContent', '=', 'DetailContentPackOrderLocal.FK_Id_ContentPack')
            ->join('OrderLocal', 'DetailContentPackOrderLocal.FK_Id_OrderLocal', '=', 'OrderLocal.Id_OrderLocal')->where('Id_OrderLocal', $id)->get();
        $SimpleOrPack = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->value('SimpleOrPack');
        $status = DB::table('OrderLocal')->where('Id_OrderLocal', $id)->value('MakeOrPackOrExpedition');

        DB::table('DispatcherOrder')->insert([
            'FK_Id_OrderLocal' => $id,
            'FK_Id_ProdStationLine' => $stationProd,
            'Date_Start' => Carbon::now(),
            'IsFinish' => 0,
        ]);

        if ($SimpleOrPack == 0) {
            $station = null;
            if ($status == 0) $station = 401;
            elseif ($status == 1 || $status == 2) $station = 406;
            foreach ($contentSimple as $item) {
                DB::table('ProcessContentSimple')->insert([
                    'FK_Id_ContentSimple' => $item->Id_SimpleContent,
                    'FK_Id_Station' => $station,
                    'FK_Id_State' => 0,
                    'Data_Start' => Carbon::now(),
                ]);
            }
        } else if ($SimpleOrPack == 1) {
            $station = null;
            if ($status == 0) $station = 401;
            elseif ($status == 1) $station = 406;
            elseif ($status == 2) $station = 406;
            foreach ($contentPack as $item) {
                DB::table('ProcessContentPack')->insert([
                    'FK_Id_ContentPack' => $item->Id_PackContent,
                    'FK_Id_Station' => $station,
                    'FK_Id_State' => 0,
                    'Data_Start' => Carbon::now(),
                ]);
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
