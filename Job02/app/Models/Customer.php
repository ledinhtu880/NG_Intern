<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'Customer';

    protected $primaryKey = "Id_Customer";

    protected $fillable = [
        'Name_Customer',
        'Email',
        'Phone',
        'Name_Contact',
        'Address',
        'Zipcode',
        'FK_Id_Mode_Transport',
        'Time_Reception'
    ];

    public $timestamps = false;
    public function transport()
    {
        return $this->belongsTo(ModeTransport::class, 'FK_Id_ModeTransport', 'Id_ModeTransport');
    }
    public function order()
    {
        return $this->hasMany(Order::class, 'FK_Id_Customer');
    }
}
