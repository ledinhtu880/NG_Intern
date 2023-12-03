<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailContentPackOrderLocal extends Model
{
    use HasFactory;

    protected $table = 'DetailContentPackOrderLocal';

    protected $fillable = [
        'FK_Id_ContentPack',
        'FK_Id_OrderLocal'
    ];

    public $timestamps = false;
}
