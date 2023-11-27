<?php

namespace App\Http\Controllers;

use App\Models\ContentPack;
use App\Models\ContentSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentSimpleController extends Controller
{
    public function addSimple(Request $request)
    {
        if ($request->ajax()) {
            $formData = $request->input('formData');
            $unit = $request->input('unit');
            $data = [];
            parse_str($formData, $formDataArray);
            $formattedPrice = number_format($formDataArray['Price_Container'], 0, ',', '.') . ' VNĐ';
            $formDataArray['unit'] = $unit;
            $formDataArray['formattedPrice'] = $formattedPrice;
            $data[] = $formDataArray;

            $maxID = DB::table('ContentSimple')->max('Id_SimpleContent');
            if ($maxID === null) {
                $id = 0; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
            } else {
                $id = $maxID + 1;
            }

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'maxID' => $id,
            ]);
        }
    }
    public function storeSimple(Request $request)
    {
        if ($request->ajax()) {
            $rowData = $request->input('rowData');
            foreach ($rowData as $row) {
                DB::table('ContentSimple')->insert([
                    'Id_SimpleContent' => $row['Id_SimpleContent'],
                    'FK_Id_RawMaterial' => $row['FK_Id_RawMaterial'],
                    'Count_RawMaterial' => $row['Count_RawMaterial'],
                    'FK_Id_ContainerType' => $row['FK_Id_ContainerType'],
                    'Count_Container' => $row['Count_Container'],
                    'Price_Container' => $row['Price_Container'],
                    'FK_Id_Order' => $row['FK_Id_Order'],
                    'ContainerProvided' => 0,
                    'PedestalProvided' => 0,
                    'RFIDProvided' => 0,
                    'RawMaterialProvided' => 0,
                ]);
            }
            $res = redirect()->route('orders.index')
                ->with('type', 'success')
                ->with('message', 'Tạo đơn hàng thành công');
            return response()->json([
                'url' => $res->getTargetUrl()
            ]);
        }
    }
    public function updateSimple(Request $request)
    {
        if ($request->ajax()) {
            $rowData = $request->input('rowData');
            foreach ($rowData as $row) {
                $id = $row['Id_SimpleContent'];
                DB::table('ContentSimple')->where('Id_SimpleContent', $id)->update([
                    'FK_Id_RawMaterial' => $row['FK_Id_RawMaterial'],
                    'Count_RawMaterial' => $row['Count_RawMaterial'],
                    'FK_Id_ContainerType' => $row['FK_Id_ContainerType'],
                    'Count_Container' => $row['Count_Container'],
                    'Price_Container' => $row['Price_Container'],
                ]);
            }
            $res = redirect()->route('orders.index')
                ->with('type', 'success')
                ->with('message', 'Sửa đơn hàng thành công');
            return response()->json([
                'url' => $res->getTargetUrl()
            ]);
        }
    }
    public function deleteSimple(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            DB::table('ContentSimple')->where('Id_SimpleContent', $id)->delete();
            return response()->json([
                'status' => 'success'
            ]);
        }
    }
    public function updateSimpleContent(Request $request)
    {
        $Id_PackContent = $request->idPackContent;
        $Id_SimpleContents = $request->idSimpleContents;
        $FK_Id_RawMaterials = $request->fkIdRawMaterials;
        $Count_RawMaterials = $request->countRawMaterials;
        $FK_Id_ContainerTypes = $request->fkIdContainerTypes;
        $Count_Containers = $request->countContainers;
        $Price_Containers = $request->priceContainers;

        // Sửa từng hàng của bảng ContentSimple
        for ($i = 0; $i < count($Id_SimpleContents); $i++) {
            $simpleContent = ContentSimple::find($Id_SimpleContents[$i]);
            $simpleContent->FK_Id_RawMaterial = $FK_Id_RawMaterials[$i];
            $simpleContent->Count_RawMaterial = $Count_RawMaterials[$i];
            $simpleContent->FK_Id_ContainerType = $FK_Id_ContainerTypes[$i];
            $simpleContent->Count_Container = $Count_Containers[$i];
            $simpleContent->Price_Container = $Price_Containers[$i];
            $simpleContent->save();
        }

        // Sửa lại tổng tiền ở bảng ContentPack
        $summ = 0;
        for ($i = 0; $i < count($Price_Containers); $i++) {
            $summ += $Price_Containers[$i] * $Count_Containers[$i];
        }
        $packContent = ContentPack::find($Id_PackContent);
        $packContent->Price_Pack = $summ;
        $packContent->save();
        $Id_Order = $packContent->FK_Id_Order;

        $result = redirect()->route('orders.editOrder', compact('Id_Order'));

        return response()->json([
            'url' => $result->getTargetUrl()
        ]);
    }
}
