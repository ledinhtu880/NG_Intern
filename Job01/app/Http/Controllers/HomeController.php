<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $booksCount = Book::count();
        $borrowingsCount = Borrowing::count();
        return view('index', compact('booksCount', 'borrowingsCount'));
    }
}
