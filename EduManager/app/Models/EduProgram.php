<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduProgram extends Model
{
    use HasFactory;
    protected $table = 'EduProgram';
    protected $primaryKey = 'Id_EP';
    public $timestamps = false;
    protected $fillable = ['FK_Id_Sub', 'FK_Id_LS', 'NumHour'];
    public static function createLesson($subjectID, $lessonType, $numHour)
    {
        return self::create([
            'FK_Id_Sub' => $subjectID,
            'FK_Id_LS' => $lessonType,
            'NumHour' => $numHour,
        ]);
    }

    public function eduProgram()
    {
        return $this->hasOne(EduProgram::class, 'FK_Id_Sub', 'Id_Sub');
    }
}
