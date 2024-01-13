<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerType extends Model
{
    use HasFactory;
    protected $table = 'ContainerType';
    protected $primaryKey = "Id_ContainerType";
    public $timestamps = false;
    public function contentSimples()
    {
        return $this->hasMany(ContentSimple::class, 'FK_Id_ContainerType', 'Id_ContainerType');
    }
}
