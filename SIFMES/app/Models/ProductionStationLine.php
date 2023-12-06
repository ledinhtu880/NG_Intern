<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionStationLine extends Model
{
    use HasFactory;

    protected $table = "ProductionStationLine";

    protected $primaryKey = 'Id_ProdStationLine';
    public $timestamps = false;

    protected $fillable = [
        'Id_ProdStationLine',
        'Name_ProdStationLine',
        'Description',
        'FK_Id_OrderType'
    ];

    public function detailProductionStationLines()
    {
        return $this->hasMany(DetailProductionStationLine::class, 'FK_Id_ProdStationLine', 'Id_ProdStationLine');
    }

    public function orderType() {
        return $this->belongsTo(OrderType::class,'FK_Id_OrderType','Id_OrderType');
    }

    public static function getIdMax() {
        $id = ProductionStationLine::max('Id_ProdStationLine');
        return $id === null ? 0 : ++$id;

    }
}
