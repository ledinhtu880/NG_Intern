<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'Subjects';
    protected $primaryKey = 'Id_Sub';
    public $timestamps = false;
    protected $fillable = ['Id_Sub', 'Sym_Sub', 'Name_Sub'];
}
