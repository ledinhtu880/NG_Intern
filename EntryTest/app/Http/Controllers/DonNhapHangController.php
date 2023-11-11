<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonNhapHang\UpdateRequest;
use App\Models\DonNhapHang;
use App\Models\LoaiHang;
use App\Models\MatHang;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonNhapHangController extends Controller
{
    public function create()
    {
        $enum = new DonNhapHang();
        $enumTypes = $enum->getEnumTypes();
        $ncc = NhaCungCap::get();
        $categories = LoaiHang::all();
        return view("donhang.create", compact('ncc', 'enumTypes', 'categories'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = new DonNhapHang();
            $data->FK_Id_NCC = $request->input('FK_Id_NCC');
            $data->Ngay_DatHang = $request->input('Ngay_DatHang');
            $data->save();

            if ($data) {
                $latestOrder = DonNhapHang::orderBy('id', 'desc')->value('id');
                return response()->json([
                    'status' => 'success',
                    'latestOrder' => $latestOrder,
                ]);
            }
        }
    }

    public function show(DonNhapHang $donhang)
    {
        $data = DB::table('chi_tiet_don_nhap')
            ->join('mat_hang', 'Id_MatHang', '=', 'FK_Id_MatHang')
            ->join('loai_hang', 'Id_LoaiHang', '=', 'FK_Id_LoaiHang')
            ->select('FK_Id_LoaiHang', 'Ten_LoaiHang', 'Ten_MatHang', 'DonViTinh', 'DonGia', 'count')
            ->where('FK_Id_DonNhapHang', '=', $donhang->id)
            ->get();
        $total = 0;
        return view('donhang.show', compact('donhang', 'data', 'total'));
    }

    public function edit(DonNhapHang $donhang)
    {
        $ncc = NhaCungCap::all();
        $enumTypes = $donhang->getEnumTypes();
        $data = DB::table('chi_tiet_don_nhap')
            ->join('mat_hang', 'Id_MatHang', '=', 'FK_Id_MatHang')
            ->join('loai_hang', 'Id_LoaiHang', '=', 'FK_Id_LoaiHang')
            ->select('chi_tiet_don_nhap.id', 'FK_Id_MatHang', 'Ten_LoaiHang', 'Ten_MatHang', 'DonViTinh', 'DonGia', 'count')
            ->where('FK_Id_DonNhapHang', '=', $donhang->id)
            ->get();
        $items = MatHang::all();
        return view('donhang.edit', compact('donhang', 'ncc', 'enumTypes', 'data', 'items'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $donhang = DonNhapHang::find($id);
        $donhang->fill($request->validated());

        $donhang->save();
        if ($donhang->wasChanged()) {
            return redirect()->route('index')->with([
                'message' => 'Đơn hàng được sửa thành công',
                'type' => 'success',
            ]);
        } else {
            return redirect()->route('index')->with([
                'message' => 'Không có gì thay đổi',
                'type' => 'info',
            ]);
        }
    }

    public function destroy(DonNhapHang $donhang)
    {
        $donhang->delete();
        return redirect()->route('index')->with([
            'message' => 'Đơn hàng được xóa thành công',
            'type' => 'success'
        ]);
    }
}
