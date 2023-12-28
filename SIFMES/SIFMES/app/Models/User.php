<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'User';
    protected $primaryKey = 'Id_User';
    public $timestamps = false;
    protected $fillable = [
        'Id_User',
        'Name',
        'UserName',
        'Password',
    ];
    public static function getIdMax()
    {
        $id = User::max('Id_User');
        return $id == null ? 0 : ++$id;
    }
}
