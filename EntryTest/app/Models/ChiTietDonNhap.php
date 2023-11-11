<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonNhap extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_don_nhap';
    protected $guarded = ['created_at', 'updated_at'];
    public $timestamps = false;
}
