<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;

    protected $table = 'OrderType';
    protected $primaryKey = "Id_OrderType";
    public $timestamps = false;
}
