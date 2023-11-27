<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'Time_Reception',
        'FK_Id_CustomerType'
    ];
    public $timestamps = false;
    public function types()
    {
        return $this->belongsTo(ModeTransport::class, 'FK_Id_Mode_Transport', 'Id_ModeTransport');
    }
    public static function getIdMax()
    {
        $id = DB::table('Customer')->max('Id_Customer');
        return $id === null ? 0 : ++$id;
    }
    public function customerType()
    {
        return $this->belongsTo(CustomerType::class, 'FK_Id_CustomerType', 'Id');
    }
}
