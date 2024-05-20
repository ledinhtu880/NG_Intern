<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningStyle extends Model
{
    use HasFactory;
    protected $table = 'LearningStyle';
    protected $primaryKey = 'Id_LS';
    public $timestamps = false;
}
