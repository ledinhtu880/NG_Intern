<?php

namespace App\Http\Controllers;

use App\Http\Requests\Material\MaterialStoreRequest;
use App\Http\Requests\Material\MaterialUpdateRequest;
use App\Models\RawMaterial;
use App\Models\RawMaterialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RawMaterialController extends Controller
{
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý nguyên liệu thô');
        }
        $types = RawMaterialType::all();
        return view('rawMaterials.index', compact('types'));
    }
    public function create()
    {
        $data = RawMaterialType::all();
        return view('rawMaterials.create', compact('data'));
    }
    public function store(MaterialStoreRequest $request)
    {
        $validator = $request->validated();
        $lastID = DB::table('RawMaterial')->max('Id_RawMaterial');
        if ($lastID === null) {
            $id = 0; // Gán giá trị mặc định cho biến $id nếu kết quả là NULL
        } else {
            $id = $lastID + 1;
        }
        DB::table('RawMaterial')->insert([
            'Id_RawMaterial' => $id,
            'Name_RawMaterial' => $validator['Name_RawMaterial'],
            'Unit' => $validator['Unit'],
            'Count' => $validator['Count'],
            'FK_Id_RawMaterialType' => $validator['FK_Id_RawMaterialType'],
        ]);
        return redirect()->route('rawMaterials.index')->with([
            'type' => 'success',
            'message' => 'Nguyên liệu thô được tạo thành công'
        ]);
    }
    public function show(string $id)
    {
        $material = RawMaterial::where('Id_RawMaterial', $id)->first();
        return view('rawMaterials.show', compact('material'));
    }
    public function edit(string $id)
    {
        $material = RawMaterial::where('Id_RawMaterial', $id)->first();
        $data = RawMaterialType::all();
        return view('rawMaterials.edit', compact('material', 'data'));
    }
    public function update(MaterialUpdateRequest $request, string $id)
    {
        $validator = $request->validated();

        $rawMaterial = RawMaterial::find($id);
        $rawMaterial->Name_RawMaterial = $validator['Name_RawMaterial'];
        $rawMaterial->Unit = $validator['Unit'];
        $rawMaterial->Count = $validator['Count'];
        $rawMaterial->FK_Id_RawMaterialType = $validator['FK_Id_RawMaterialType'];
        $rawMaterial->save();

        if ($rawMaterial->wasChanged()) {
            return redirect()->route('rawMaterials.index')->with([
                'message' => 'Sửa nguyên liệu thô thành công',
                'type' => 'success'
            ]);
        } else {
            return redirect()->route('rawMaterials.index')->with([
                'message' => 'Không có thay đổi dữ liệu nguyên liệu thô',
                'type' => 'info'
            ]);
        }
    }
    public function destroy(string $id)
    {
        $exists = DB::table('ContentSimple')
            ->where('FK_Id_RawMaterial', $id)
            ->exists();
        if ($exists) {
            return redirect()->route('rawMaterials.index')->with([
                'message' => 'Không thể xóa nguyên liệu thô này do nó đã tồn tại trong thùng hàng.',
                'type' => 'danger',
            ]);
        } else {
            RawMaterial::where('Id_RawMaterial', '=', $id)->delete();

            return redirect()->route('rawMaterials.index')->with([
                'message' => 'Xóa nguyên liệu thô thành công',
                'type' => 'success',
            ]);
        }
    }
    public function showRawMaterialsByType(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('RawMaterialType')
                ->select('Id_RawMaterial', 'Name_RawMaterial', 'Unit', 'count', 'Name_RawMaterialType')
                ->join('RawMaterial', 'FK_Id_RawMaterialType', '=', 'Id_RawMaterialType')
                ->where('Id_RawMaterialType', '=', $request->id)
                ->get();
            return response()->json([
                'status'     => 'success',
                'data' => $data,
            ]);
        }
    }
    public function showUnit(Request $request)
    {
        if ($request->ajax()) {
            $unit = DB::table('RawMaterial')
                ->where('Id_RawMaterial', $request->input('id'))
                ->value('RawMaterial.Unit');
            return response()->json([
                'status' => 'success',
                'unit' => $unit,
            ]);
        }
    }
}
