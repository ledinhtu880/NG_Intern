<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiHang extends Model
{
    use HasFactory;
    protected $table = 'loai_hang';
    public $timestamps = false;
}
