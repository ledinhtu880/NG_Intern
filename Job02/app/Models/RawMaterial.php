<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;
    protected $fillable = ['Name_RawMaterial', 'Unit', 'count', 'FK_Id_RawMaterialType'];
    protected $primaryKey = "Id_RawMaterial";
    protected $table = 'RawMaterial';
    public $timestamps = false;
    public function types()
    {
        return $this->belongsTo(RawMaterialType::class, 'FK_Id_RawMaterialType', 'Id_RawMaterialType');
    }
    public function contentSimples()
    {
        return $this->hasMany(ContentSimple::class, 'FK_Id_RawMaterial', 'Id_RawMaterial');
    }
}
