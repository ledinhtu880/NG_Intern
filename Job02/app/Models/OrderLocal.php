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
        'DateDilivery',
        'SimpleOrPack',
        'MakeOrPackOrExpedition',
        'Data_Start',
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
