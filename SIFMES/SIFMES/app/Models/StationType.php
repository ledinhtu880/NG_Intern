<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationType extends Model
{
    use HasFactory;
    protected $table = 'StationType';
    public $timestamps = false;
    public function station()
    {
        return $this->hasMany(Station::class, 'FK_Id_StationType', 'Id_StationType');
    }
}
