<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderMakeOrExpedition extends Model
{
    use HasFactory;
    protected $table = 'OrderMakeOrExpedition';
    protected $primaryKey = "Id_OrderMakeOrExpedition";
    protected $fillable = [
        'Id_OrderMakeOrExpedition',
        'Count',
        'DateDilivery',
        'SimpleOrPack',
        'MakeOrExpedition',
        'Data_Start',
    ];
    public $timestamps = false;
    public function getTypeAttribute()
    {
        return $this->SimpleOrPack ? 'Gói hàng' : 'Thùng hàng';
    }
    public function getStatusAttribute()
    {
        return $this->SimpleOrPack ? 'Giao hàng' : 'Sản xuất';
    }
    public function getDeliveryDateAttribute()
    {
        $dateDelivery = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->DateDilivery);

        return $dateDelivery->format('d/m/Y');
    }
    public function getStartDateAttribute()
    {
        $dateStart = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Data_Start);

        return $dateStart->format('d/m/Y');
    }
    public function getFinallyDateAttribute()
    {
        if ($this->Date_Fin == null) {
            return "Chưa hoàn thành";
        } else {
            $dateFinally = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Data_Fin);

            return $dateFinally->format('d/m/Y');
        }
    }
}
