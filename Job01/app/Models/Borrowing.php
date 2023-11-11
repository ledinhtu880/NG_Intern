<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];
    public $timestamps = false;
    public function book()
    {
        $this->belongsTo(Book::class, 'BookID', 'BookID');
    }
    public function getBookTitleAttribute()
    {
        $title = Book::where('BookID', '=', $this->BookID)->value('Title');
        return $title;
    }
    public function getBorrowTimeAttribute()
    {
        return date('d/m/Y', strtotime($this->BorrowDate));
    }
    public function getDueTimeAttribute()
    {
        return date('d/m/Y', strtotime($this->DueDate));
    }
    public function getReturnedTimeAttribute()
    {
        return date('d/m/Y', strtotime($this->ReturnedDate));
    }
}
