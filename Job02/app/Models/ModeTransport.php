<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeTransport extends Model
{
    use HasFactory;
    protected $table = 'ModeTransport';
    protected $primaryKey = "Id_ModeTransport";
    public $timestamps = false;
    public function customers()
    {
        return $this->hasMany(Customer::class, 'FK_Id_ModeTransport', 'Id_ModeTransport');
    }
}
