<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailProductionStationLine;

class ProductStationLine extends Model
{
    use HasFactory;
    protected $table = 'ProductStationLine';
    public $timestamps = false;
    public function details()
    {
        return $this->hasMany(DetailProductionStationLine::class, 'FK_Id_ProdStationLine', 'Id_ProdStationLine');
    }
}
