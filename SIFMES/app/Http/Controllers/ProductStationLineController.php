<?php

namespace App\Http\Controllers;

use App\Models\DetailProductionStationLine;
use App\Models\OrderType;
use Illuminate\Http\Request;
use App\Models\ProductionStationLine;
use Illuminate\Support\Facades\DB;

class ProductStationLineController extends Controller
{
    public function create()
    {
        return view('productStationLines.create', ['orderTypes' => OrderType::all()]);
    }
    public function store(Request $request)
    {
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

        $redirectResponse = redirect()->route('productStationLines.show', ['productStationLine' => $Id_ProdStationLine])->with([
            'type' => 'success',
            'message' => 'Thêm dây chuyền mới thành công'
        ]);


        return response()->json([
            'url' => $redirectResponse->getTargetUrl()
        ]);
    }
    public function show(ProductionStationLine $productStationLine)
    {
        return view('productStationLines.show', ['detailProductionStationLines' => $productStationLine->detailProductionStationLines, 'productStationLine' => $productStationLine]);
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

        $redirectResponse = redirect()->route('productStationLines.show', ['productStationLine' => $productStationLine_id])->with([
            'type' => 'success',
            'message' => 'Sửa dây chuyền thành công'
        ]);


        return response()->json([
            'url' => $redirectResponse->getTargetUrl()
        ]);
        // return $productStationLine;
    }

    public function destroy(ProductionStationLine $productStationLine)
    {
        DetailProductionStationLine::where('FK_Id_ProdStationLine', $productStationLine->Id_ProdStationLine)->delete();
        $productStationLine->delete();
        return redirect()->route('index')->with([
            'type' => 'success',
            'message' => 'Xóa dây chuyền xử lý sản xuất thành công'
        ]);
    }
}
