<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProductionStationLine extends Model
{
    use HasFactory;
    protected $table = 'DetailProductionStationLine';
    public $timestamps = false;
    protected $fillable = [
        'FK_Id_ProdStationLine',
        'FK_Id_Station'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class, 'FK_Id_Station', 'Id_Station');
    }
    public function productionStationLine()
    {
        return $this->belongsTo(ProductionStationLine::class, 'FK_Id_ProdStationLine', 'Id_ProdStationLine');
    }
}
