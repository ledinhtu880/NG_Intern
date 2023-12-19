<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        if ($this->Date_Order != null) {
            $dateOrder = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Order);

            return $dateOrder->format('d/m/Y');
        }
        return 'Chưa đặt hàng';
    }

    public function getDeliveryDateAttribute()
    {
        if ($this->Date_Dilivery != null) {
            $dateDelivery = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Dilivery);

            return $dateDelivery->format('d/m/Y');
        }
        return 'Chưa giao hàng';
    }
    public function getReceptionDateAttribute()
    {
        if ($this->Date_Reception != null) {
            $dateReception = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Reception);

            return $dateReception->format('d/m/Y');
        }
        return 'Chưa nhận hàng';
    }
}
