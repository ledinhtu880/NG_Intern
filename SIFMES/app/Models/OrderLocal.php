<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderLocal extends Model
{
    use HasFactory;
    protected $table = 'OrderLocal';
    protected $primaryKey = "Id_OrderLocal";
    protected $fillable = [
        'Id_OrderLocal',
        'Count',
        'Date_Delivery',
        'SimpleOrPack',
        'MakeOrPackOrExpedition',
        'Date_Start',
    ];
    public $timestamps = false;
    public function getTypeAttribute()
    {
        return $this->SimpleOrPack ? 'Gói hàng' : 'Thùng hàng';
    }
    public function getStatusAttribute()
    {
        if ($this->MakeOrPackOrExpedition == 0) {
            return "Sản xuất";
        } else if ($this->MakeOrPackOrExpedition == 1) {
            return "Gói hàng";
        } else if ($this->MakeOrPackOrExpedition == 2) {
            return "Giao hàng";
        }
    }
    public function getDeliveryDateAttribute()
    {
        if ($this->Date_Delivery != null) {
            $dateDelivery = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Delivery);
            return $dateDelivery->format('d/m/Y');
        }
        return 'Chưa giao hàng';
    }
    public function getStartDateAttribute()
    {
        if ($this->Date_Start != null) {
            $dateStart = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Start);
            return $dateStart->format('d/m/Y');
        }
        return 'Chưa bắt đầu';
    }
    public function getFinallyDateAttribute()
    {
        if ($this->Date_Fin != null) {
            $dateFinally = Carbon::createFromFormat('Y-m-d H:i:s.u', $this->Date_Fin);
            return $dateFinally->format('d/m/Y');
        }
        return 'Chưa hoàn thành';
    }
}
