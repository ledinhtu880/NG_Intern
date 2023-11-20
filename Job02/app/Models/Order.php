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
        $dateOrder = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Order);

        return $dateOrder->format('Y-m-d');
    }

    public function getDeliveryDateAttribute()
    {
        $dateDelivery = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Dilivery);

        return $dateDelivery->format('Y-m-d');
    }
    public function getReceptionDateAttribute()
    {
        $dateReception = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Reception);

        return $dateReception->format('Y-m-d');
    }
}
