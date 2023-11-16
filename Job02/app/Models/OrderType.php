<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;

    protected $table = 'OrderType';
    protected $primaryKey = "Id_OrderType";
    public $timestamps = false;
    public function orders()
    {
        return $this->hasMany(Order::class, 'Id_Order', 'FK_Id_Order');
    }
}
