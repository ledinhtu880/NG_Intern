<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPack extends Model
{
    use HasFactory;
    protected $table = 'ContentPack';
    protected $primaryKey = "Id_ContentPack";
    public $timestamps = false;
    public function order()
    {
        return $this->belongsTo(Order::class, 'FK_Id_Order', 'Id_Order');
    }
}
