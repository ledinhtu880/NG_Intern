<?php

namespace App\Models;

use App\Models\DonNhapHang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;
    protected $table = 'nha_cung_cap';
    public $timestamps = false;
    public function DonNhapHang()
    {
        return $this->hasMany(DonNhapHang::class);
    }
}
