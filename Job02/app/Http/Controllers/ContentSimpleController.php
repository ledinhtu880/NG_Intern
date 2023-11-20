<?php

namespace App\Http\Controllers;

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

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        }
    }
    public function storeSimple(Request $request)
    {
        if ($request->ajax()) {
            $rowData = $request->input('rowData');
            foreach ($rowData as $row) {
                $lastOrderId = DB::table('ContentSimple')->max('Id_SimpleContent');

                if ($lastOrderId === null) {
                    $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
                } else {
                    $id = $lastOrderId + 1;
                }

                DB::table('ContentSimple')->insert([
                    'Id_SimpleContent' => $id,
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

            return response()->json([
                'status' => 'success',
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

            return response()->json([
                'status' => 'success',
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
}
