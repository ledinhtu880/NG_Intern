<?php

namespace App\Http\Controllers;

use App\Models\ProductionStationLine;
use App\Models\DetailProductionStationLine;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductionStationLineController extends Controller
{
    public function create()
    {
        return view('productionStationLines.create');
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
        $productionStationLine = ProductionStationLine::create($data);
        for ($i = 0; $i < count($stationLine); $i++) {
            DetailProductionStationLine::create([
                'FK_Id_Station' => $stationLine[$i],
                'FK_Id_ProdStationLine' => $Id_ProdStationLine
            ]);
        }
        $redirectResponse = redirect()->route('productionStationLines.show', ['productionStationLine' => $Id_ProdStationLine])->with([
            'type' => 'success',
            'message' => 'Thêm dây chuyền mới thành công'
        ]);
        return response()->json([
            'url' => $redirectResponse->getTargetUrl()
        ]);
    }
    public function show(ProductionStationLine $productionStationLine)
    {
        return view('productionStationLines.show', ['detailProductionStationLines' => $productionStationLine->detailProductionStationLines, 'productionStationLine' => $productionStationLine]);
    }
    public function edit(ProductionStationLine $productionStationLine)
    {
        return view('productionStationLines.edit', [
            'productionStationLine' => $productionStationLine,
            'detailProductionStationLine' => DetailProductionStationLine
                ::where('FK_Id_ProdStationLine', $productionStationLine->Id_ProdStationLine)
                ->get()
        ]);
    }
    public function update(Request $request, string $productionStationLine_id)
    {
        $stationLine = $request->stationLine;
        $data = [
            'Name_ProdStationLine' => $request->name,
            'Description' => $request->description,
            'FK_Id_OrderType' => intval($request->orderType)
        ];
        $productionStationLine = ProductionStationLine::find($productionStationLine_id);
        $productionStationLine->update($data);
        DB::table('DetailProductionStationLine')->where('FK_Id_ProdStationLine', $productionStationLine_id)->delete();
        for ($i = 0; $i < count($stationLine); $i++) {
            DetailProductionStationLine::create([
                'FK_Id_Station' => $stationLine[$i],
                'FK_Id_ProdStationLine' => $productionStationLine_id,
            ]);
        }
        $redirectResponse = redirect()->route('productionStationLines.show', ['productionStationLine' => $productionStationLine_id])->with([
            'type' => 'success',
            'message' => 'Sửa dây chuyền thành công'
        ]);
        return response()->json([
            'url' => $redirectResponse->getTargetUrl()
        ]);
        // return $productionStationLine;
    }
    public function destroy(ProductionStationLine $productionStationLine)
    {
        DetailProductionStationLine::where('FK_Id_ProdStationLine', $productionStationLine->Id_ProdStationLine)->delete();
        $productionStationLine->delete();
        return redirect()->route('index')->with([
            'type' => 'success',
            'message' => 'Xóa dây chuyền xử lý sản xuất thành công'
        ]);
    }
}
