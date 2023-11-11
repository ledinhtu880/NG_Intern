<?php

namespace App\Models;

use App\Models\NhaCungCap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DonNhapHang extends Model
{
    use HasFactory;
    protected $table = 'don_nhap_hang';
    protected $fillable = ['FK_Id_NCC', 'TrangThai', 'Ngay_DatHang'];
    public $timestamps = false;
    protected $enumTypes = ['Đang chờ xử lý', 'Đã được xử lý', 'Đang vận chuyển', 'Hoàn thành'];
    public function getEnumTypes()
    {
        return $this->enumTypes;
    }
    public function NhaCungCaps()
    {
        return $this->belongsTo(NhaCungCap::class, 'FK_Ncc_id');
    }
    public function getSupplierAttribute(string $attribute, string $id)
    {
        return DB::table('nha_cung_cap')
            ->join('don_nhap_hang', 'Id_NCC', '=', 'FK_Id_NCC')
            ->where('id', '=', $id)
            ->value($attribute);
    }
}
