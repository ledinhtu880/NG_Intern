<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonNhap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ChiTietDonNhapController extends Controller
{
  public function addData(Request $request)
  {
    if ($request->ajax()) {
      $data = new ChiTietDonNhap();
      $data->FK_Id_DonNhapHang = $request->input('FK_Id_DonNhapHang');
      $data->FK_Id_MatHang = $request->input('FK_Id_MatHang');
      $data->count = $request->input('count');
      $data->save();

      if ($data) {
        $row = DB::table('chi_tiet_don_nhap')
          ->join('mat_hang', 'Id_MatHang', '=', 'FK_Id_MatHang')
          ->join('loai_hang', 'Id_LoaiHang', '=', 'FK_Id_LoaiHang')
          ->select('Ten_LoaiHang', 'Ten_MatHang', 'DonViTinh', 'DonGia', 'count')
          ->where('FK_Id_DonNhapHang', '=', $request->FK_Id_DonNhapHang)
          ->get();
        return response()->json([
          'status'     => 'success',
          'FK_Id_DonNhapHang'     => $data->FK_Id_DonNhapHang,
          'FK_Id_MatHang'     => $data->FK_Id_MatHang,
          'count'     => $data->count,
          'row' => $row,
        ]);
      } else {
        return response()->json([
          'status' => 'error'
        ]);
      }
    }
  }
  public function updateData(Request $request)
  {
    if ($request->ajax()) {
      $formData = $request->input('formData');
      $data = [];

      foreach ($formData as $form) {
        $pairs = explode('&', $form);
        $formDataArray = [];

        foreach ($pairs as $pair) {
          $parts = explode('=', $pair);
          $key = $parts[0];
          $value = $parts[1];

          $formDataArray[$key] = $value;
        }

        $data[] = $formDataArray;
      }

      foreach ($data as $value) {
        ChiTietDonNhap::where('id', '=', $value['id'])->update([
          'FK_Id_MatHang' => $value['FK_Id_MatHang'],
          'count' => $value['count'],
        ]);
      }

      Session::flash('success', 'success');
      Session::flash('message', 'Sửa chi tiết đơn hàng thành công');
      return response()->json([
        'status' => 'success',
        'formData' => $data,
      ]);
    }
  }
  public function deleteData(Request $request)
  {
    if ($request->ajax()) {
      $id = $request->input('id');
      $chiTietDonHang = ChiTietDonNhap::find($id);

      if ($chiTietDonHang) {
        $chiTietDonHang->delete();

        return response()->json([
          'status' => 'success',
        ]);
      } else {
        return response()->json([
          'status' => 'error',
          'message' => 'Không tìm thấy chi tiết đơn hàng.',
        ]);
      }
    }
  }
}
