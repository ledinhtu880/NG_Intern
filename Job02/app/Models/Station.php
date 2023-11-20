<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'Station';
    public $timestamps = false;
    protected $primaryKey = 'Id_Station';
    protected $fillable = [
        'Name_Station',
        'Ip_Address',
        'FK_Id_StationType'
    ];
    public function stationType()
    {
        return $this->belongsTo(StationType::class, 'FK_Id_StationType', 'Id_StationType');
    }
    public function detailProductionStationLines()
    {
        return $this->hasMany(DetailProductionStationLine::class, 'FK_Id_Station', 'Id_Station');
    }
}
