<?php

namespace App\Http\Controllers;

use App\Models\DetailProductionStationLine;
use App\Models\OrderType;
use App\Models\Station;
use App\Models\ProductionStationLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductStationLineController extends Controller
{
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Dây chuyền sản xuất');
        }
        return view(
            'productStationLines.index',
            [
                'data' => ProductionStationLine::paginate(5),
            ]
        );
    }
    public function create()
    {
        return view('productStationLines.create', ['orderTypes' => OrderType::all()]);
    }
    public function store(Request $request)
    {
        $Name_ProdStationLine = $request->name;
        $isDuplicate = ProductionStationLine::where('Name_ProdStationLine', $Name_ProdStationLine)->exists();
        if ($isDuplicate) {
            return response()->json([
                'message' => 'Tên dây chuyền đã tồn tại',
                'status' => 400
            ]);
        }
        $Id_ProdStationLine = ProductionStationLine::getIdMax();
        $stationLine = $request->stationLine;
        $data = [
            'Id_ProdStationLine' => $Id_ProdStationLine,
            'Name_ProdStationLine' => $request->name,
            'Description' => $request->description,
            'FK_Id_OrderType' => intval($request->orderType)
        ];
        $productStationLine = ProductionStationLine::create($data);

        for ($i = 0; $i < count($stationLine); $i++) {
            DetailProductionStationLine::create([
                'FK_Id_Station' => $stationLine[$i],
                'FK_Id_ProdStationLine' => $Id_ProdStationLine
            ]);
        }

        $redirectResponse = redirect()->route('productStationLines.index')->with([
            'type' => 'success',
            'message' => 'Thêm dây chuyền mới thành công',
        ]);


        return response()->json([
            'url' => $redirectResponse->getTargetUrl(),
            'status' => 200
        ]);
    }

    public function edit(ProductionStationLine $productStationLine)
    {
        return view('productStationLines.edit', [
            'productStationLine' => $productStationLine,
            'detailProductionStationLine' => DetailProductionStationLine::where('FK_Id_ProdStationLine', $productStationLine->Id_ProdStationLine)->get(),
            'orderTypes' => OrderType::all()
        ]);
    }

    public function update(Request $request, string $productStationLine_id)
    {
        $Name_ProdStationLine = $request->name;
        $isDuplicate = ProductionStationLine::where('Name_ProdStationLine', $Name_ProdStationLine)->where('Id_ProdStationLine', '!=', $productStationLine_id)->exists();
        if ($isDuplicate) {
            return response()->json([
                'message' => 'Tên dây chuyền đã tồn tại',
                'status' => 400
            ]);
        }
        $stationLine = $request->stationLine;
        $data = [
            'Name_ProdStationLine' => $request->name,
            'Description' => $request->description,
            'FK_Id_OrderType' => intval($request->orderType)
        ];
        $productStationLine = ProductionStationLine::find($productStationLine_id);
        $productStationLine->update($data);
        DB::table('DetailProductionStationLine')->where('FK_Id_ProdStationLine', $productStationLine_id)->delete();
        for ($i = 0; $i < count($stationLine); $i++) {
            DetailProductionStationLine::create([
                'FK_Id_Station' => $stationLine[$i],
                'FK_Id_ProdStationLine' => $productStationLine_id,
            ]);
        }
        $redirectResponse = redirect()->route('productStationLines.index')->with([
            'type' => 'success',
            'message' => 'Sửa dây chuyền thành công',
        ]);
        return response()->json([
            'url' => $redirectResponse->getTargetUrl(),
            'status' => 200
        ]);
    }

    public function destroy(ProductionStationLine $productStationLine)
    {
        $exists = DB::table('DispatcherOrder')->where('FK_Id_ProdStationLine', $productStationLine->Id_ProdStationLine)->exists();
        if ($exists) {
            return redirect()->route('productStationLines.index')->with([
                'type' => 'warning',
                'message' => 'Không thể xóa dây chuyền này'
            ]);
        } else {
            DetailProductionStationLine::where('FK_Id_ProdStationLine', $productStationLine->Id_ProdStationLine)->delete();
            $productStationLine->delete();
            return redirect()->route('productStationLines.index')->with([
                'type' => 'success',
                'message' => 'Xóa dây chuyền thành công'
            ]);
        }
    }
}
