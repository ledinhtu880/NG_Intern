<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'Station';
    public $timestamps = false;
    public function types()
    {
        return $this->belongsTo(StationType::class, 'FK_Id_StationType', 'Id_StationType');
    }
    public function stationLines()
    {
        return $this->hasMany(DetailProductionStationLine::class, 'FK_Id_ProdStationLine', 'Id_ProdStationLine');
    }
}
