<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialType extends Model
{
    use HasFactory;
    protected $table = 'RawMaterialType';
    public $timestamps = false;
    public function materials()
    {
        return $this->hasMany(RawMaterial::class, 'FK_Id_RawMaterialType', 'Id_RawMaterialType');
    }
    public function getIDAttribute()
    {
        return $this->Id_RawMaterialType;
    }
    public function getNameAttribute()
    {
        return $this->Name_RawMaterialType;
    }
}
