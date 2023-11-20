<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\ContainerType;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ContentPackController extends Controller
{
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý đơn lô hàng');
        }
        $data = Order::where('isSimple', 0)->paginate(5);
        return view('packs.index', compact('data'));
    }
    public function create()
    {
        $customers = Customer::get();
        $containers = ContainerType::get();
        $materials = RawMaterial::get();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $information = DB::table('Order')
                ->select('FK_Id_Customer', 'Date_Order', 'Date_Dilivery', 'Date_Reception', 'Note')
                ->where('Id_Order', $id)
                ->first();
            $data = DB::table('ContentPack')->select('Id_PackContent', 'Count_Pack', 'Price_Pack')
                ->where('FK_Id_Order', $id)
                ->get();
            return view('packs.create', [
                'customers' => $customers,
                'containers' => $containers,
                'materials' => $materials,
                'information' => $information,
                'data' => $data,
                'count' => 1,
            ]);
        } else {
            return view('packs.create', [
                'customers' => $customers,
                'containers' => $containers,
                'materials' => $materials,
            ]);
        }
    }
    public function createPack(Request $request)
    {
        $customers = Customer::get();
        $containers = ContainerType::get();
        $materials = RawMaterial::get();

        return view('packs.createPack', [
            'customers' => $customers,
            'containers' => $containers,
            'materials' => $materials,
        ]);
    }
    public function storePack(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->input('packData');

            $lastOrderId = DB::table('ContentPack')->max('Id_PackContent');

            if ($lastOrderId === null) {
                $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
            } else {
                $id = $lastOrderId + 1;
            }

            DB::table('ContentPack')->insert([
                'Id_PackContent' => $id,
                'Count_Pack' => $data['Count_Pack'],
                'Price_Pack' => $data['Price_Pack'],
                'FK_Id_Order' => $data['FK_Id_Order'],
                'HaveEilmPE' => 0,
                'HaveNFC' => 0,
            ]);

            return response()->json([
                'status' => 'success',
                'id' => $id,
            ]);
        }
    }
    public function storeDetailContentSimpleOfPack(Request $request)
    {
        if ($request->ajax()) {
            $OrderID = $request->input('FK_Id_Order');
            $packID = $request->input('Id_PackContent');
            $IdArr = DB::table('ContentSimple')
                ->where('FK_Id_Order', $OrderID)
                ->pluck('Id_SimpleContent')
                ->toArray();
            foreach ($IdArr as $each) {
                DB::table('DetailContentSimpleOfPack')->insert([
                    'FK_Id_SimpleContent' => $each,
                    'FK_Id_PackContent' => $packID,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'id' => $OrderID,
            ]);
        }
    }
    public function deletePack(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $Id_Order = $request->input('Id_Order');
            DB::table('DetailContentSimpleOfPack')->where('FK_Id_PackContent', $id)->delete();
            DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->delete();
            DB::table('ContentPack')->where('FK_Id_Order', $Id_Order)->delete();

            return response()->json([
                'status' => 'success'
            ]);
        }
    }
}
