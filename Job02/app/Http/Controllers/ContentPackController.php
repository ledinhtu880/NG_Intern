<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\ContainerType;
use App\Models\RawMaterial;
use App\Models\ContentSimple;
use App\Models\ContentPack;
use App\Models\DetailContentSimpleOfPack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ContentPackController extends Controller
{
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý đơn gói hàng');
        }
        $data = Order::where('SimpleOrPack', 1)->paginate(5);
        return view('packs.index', compact('data'));
    }
    public function showFormEditSimple(string $Id_PackContent)
    {
        $details = DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->get();
        $id_SimpleContents = [];
        foreach ($details as $detail) {
            $id_SimpleContents[] = $detail->FK_Id_SimpleContent;
        }
        $simpleContents = [];
        for ($i = 0; $i < count($id_SimpleContents); $i++) {
            $simpleContents[] = ContentSimple::find($id_SimpleContents[$i]);
        }
        $materials = RawMaterial::all();
        $containerTypes = ContainerType::all();
        // return $simpleContents;
        return view('packs.edits.editSimpleContent', compact('simpleContents', 'materials', 'containerTypes', 'Id_PackContent'));
    }
    public function create()
    {
        $customers = Customer::get();
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
                'information' => $information,
                'data' => $data,
                'count' => 1,
            ]);
        } else {
            return view('packs.create', [
                'customers' => $customers,
            ]);
        }
    }
    public function createPack()
    {
        $containers = ContainerType::get();
        $materials = RawMaterial::get();
        return view('packs.createPack', [
            'containers' => $containers,
            'materials' => $materials,
        ]);
    }
    public function storePack(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->input('packData');
            $maxID = DB::table('ContentPack')->max('Id_PackContent');
            if ($maxID === null) {
                $id = 1; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
            } else {
                $id = $maxID + 1;
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
            $idArr = $request->input('idArr');
            foreach ($idArr as $each) {
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
    public function destroyOrder(string $Id_Order)
    {
        // Xóa dữ liệu ở bảng DetailContentSimpleOfPack trước
        $contentPack = DB::table('ContentPack')->where('FK_Id_Order', $Id_Order)->get();
        $contentSimple = DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->get();
        foreach ($contentSimple as $each) {
            $Id_ContentSimple = $each->Id_SimpleContent;
            // Xóa DetailContentSimpleOfPack
            DB::table('DetailContentSimpleOfPack')->where('FK_Id_SimpleContent', $Id_ContentSimple)->delete();
        }
        // Xóa dữ liệu bảng ContentPack
        DB::table('ContentPack')->where('FK_Id_Order', $Id_Order)->delete();
        // Xóa dữ liệu bảng ContentSimple
        $contentSimple = DB::table('ContentSimple')->where('FK_Id_Order', $Id_Order)->delete();
        // Xóa dữ liệu bảng order
        Order::find($Id_Order)->delete();
        return redirect()->route('packs.index')
            ->with('type', 'success')
            ->with('message', 'Xóa đơn gói hàng thành công');
    }

    public function destroySimpleContent(Request $request)
    {
        $Id_SimpleContent = $request->Id_SimpleContent;
        $Id_PackContent = $request->Id_PackContent;
        DetailContentSimpleOfPack::where('FK_Id_SimpleContent', $Id_SimpleContent)->delete();
        $contentSimple = ContentSimple::find($Id_SimpleContent);
        $price_Container = $contentSimple->Price_Container;
        $contentSimple->delete();
        $detail = DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->get();
        $result = '';
        $contentPack = ContentPack::find($Id_PackContent);

        if ($detail->isEmpty()) {
            $Id_Order = $contentPack->FK_Id_Order;
            $contentPack->delete();
            $result = redirect()->route('orders.editOrder', compact('Id_Order'))
                ->with('type', 'success')
                ->with('message', 'Xóa thùng hàng mã: ' . $Id_SimpleContent . ' thành công');
        } else {
            $price_Pack = $contentPack->Price_Pack;
            $contentPack->Price_Pack = $price_Pack - $price_Container;
            $contentPack->save();
            $result = redirect()->back()->with('type', 'success')->with('message', 'Xóa thùng hàng mã: ' . $Id_SimpleContent . ' thành công');
        }
        return response()->json([
            'url' => $result->getTargetUrl()
        ]);
    }

    public function destroyPackContent(Request $request)
    {
        $Id_PackContent = $request->idPackContent;
        $Id_Order = $request->idOrder;

        // Lấy Id_Simplecontent
        $details = DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->get();
        $Id_SimpleContents = [];
        // Lấy các bản ghi của simplecontent có trong packcontent
        foreach ($details as $detail) {
            $Id_SimpleContents[] = $detail->FK_Id_SimpleContent;
        }
        // Xóa các bản ghi ở bảng DetailContentSimpleOfPack có liên quan tới packcontent 
        DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->delete();

        for ($i = 0; $i < count($Id_SimpleContents); $i++) {
            ContentSimple::find($Id_SimpleContents[$i])->delete();
        }
        // Xóa bản ghi có Id_PackContent trong bảng ContentPack
        ContentPack::find($Id_PackContent)->delete();

        $res = redirect()->back()->with('type', 'success')->with('message', 'Xóa thành công');
        return response()->json([
            'url' => $res->getTargetUrl()
        ]);
    }
}
