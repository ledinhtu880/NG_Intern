<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'Order';
    protected $primaryKey = "Id_Order";
    public $timestamps = false;
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'FK_Id_Customer', 'Id_Customer');
    }
    public function type()
    {
        return $this->belongsTo(OrderType::class, 'FK_Id_OrderType', 'Id_OrderType');
    }
    public function contentPacks()
    {
        return $this->hasMany(ContentPack::class, 'Id_Order', 'FK_Id_Order');
    }
    public function contentSimples()
    {
        return $this->hasMany(ContentSimple::class, 'Id_Order', 'FK_Id_Order');
    }
    public function getOrderDateAttribute()
    {
        return date('d/m/Y', strtotime($this->Date_Order));
    }
}
