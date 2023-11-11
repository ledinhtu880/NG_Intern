<?php

namespace App\Http\Controllers;

use App\Models\MatHang;
use Illuminate\Http\Request;

class MatHangController extends Controller
{
    public function showItemsInCategory(Request $request)
    {
        if ($request->ajax()) {
            $matHang = MatHang::where('FK_Id_LoaiHang', '=', $request->Id_LoaiHang)
                ->select('Id_MatHang', 'Ten_MatHang')->get();

            return response()->json($matHang);
        }
    }
    public function showDetailsItem(Request $request)
    {
        if ($request->ajax()) {
            $matHang = MatHang::join('chi_tiet_don_nhap', 'Id_MatHang', '=', 'FK_Id_MatHang')
                ->join('loai_hang', 'Id_LoaiHang', '=', 'FK_Id_LoaiHang')
                ->where('FK_Id_MatHang', $request->FK_Id_MatHang)
                ->select('Ten_LoaiHang', 'DonViTinh', 'DonGia')
                ->first();

            return response()->json($matHang);
        }
    }
}
