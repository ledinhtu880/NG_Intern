<?php

namespace App\Http\Controllers;

use App\Http\Requests\Borrowing\BorrowingStoreRequest;
use App\Http\Requests\Borrowing\BorrowingUpdateRequest;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::orderBy('BorrowingID', 'desc')->paginate(10);
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Show all borrowings');
        }
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all();
        return view('borrowings.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowingStoreRequest $request)
    {
        $borrowing = new Borrowing();
        $borrowing->fill($request->validated());
        $borrowing->save();
        return redirect()->route('borrowings.index')->with([
            'type' => 'success',
            'message' => 'Borrowing created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrowing = Borrowing::where('BorrowingID', '=', $id)->first();
        $book = DB::table('books')
            ->select('Title', 'Author', 'Genre', 'PublishedYear')
            ->join('borrowings', 'books.BookID', '=', 'borrowings.BookID')
            ->where('borrowings.BorrowingID', '=', $borrowing->BorrowingID)
            ->first();
        return view('borrowings.show', compact('borrowing', 'book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $borrowing = Borrowing::where('BorrowingID', '=', $id)->first();
        $books = Book::all();
        return view('borrowings.edit', compact('borrowing', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BorrowingUpdateRequest $request, string $id)
    {
        $validator = $request->validated();
        Borrowing::where('BorrowingID', '=', $id)->update([
            'BookID' => $validator['BookID'],
            'MemberID' => $validator['MemberID'],
            'BorrowDate' => $validator['BorrowDate'],
            'DueDate' => $validator['DueDate'],
            'ReturnedDate' => $validator['ReturnedDate'],
        ]);

        return redirect()->route('borrowings.index')->with([
            'message' => 'Borrowing updated successfully',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Borrowing::where('BorrowingID', '=', $id)->delete();

        return redirect()->route('borrowings.index')->with([
            'message' => 'Borrowing destroyed successfully',
            'type' => 'danger',
        ]);
    }
}
