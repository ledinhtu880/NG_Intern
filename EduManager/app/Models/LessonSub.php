<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonSub extends Model
{
    use HasFactory;
    protected $table = 'LessonSub';
    protected $primaryKey = 'Id_Les';
    public $timestamps = false;
    protected $fillable = ['Les_Unit', 'Les_Name', 'FK_Id_Sub', 'FK_Id_LS', 'NumHour'];
}
