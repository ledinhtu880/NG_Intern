@extends('layouts.master')

@section ('title', 'Create Borrowing')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50 mt-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title m-0">Create Borrowing Form</h3>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('borrowings.store') }}">
              @csrf
              <div class="form-group">
                <div class="form-group">
                  <label for="BookID" class="form-label">Book</label>
                  <select name="BookID" class="form-select{{ $errors->has('BookID') ? ' is-invalid' : '' }}">
                    <option value="default">Select a Book</option>
                    @foreach($books as $book)
                    <option value="{{ $book->BookID }}">{{ $book->Title }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('BookID'))
                  <span class="text-danger">
                    {{ $errors->first('BookID') }}
                  </span>
                  @endif
                </div>
                <label for="MemberID" class="form-label">Member ID</label>
                <input type="number" name="MemberID" id="MemberID" placeholder="Enter Member..."
                  value="{{ old('MemberID')}}" class="form-control{{ $errors->has('MemberID') ? ' is-invalid' : '' }}">
                @if ($errors->has('MemberID'))
                <span class="text-danger">
                  {{ $errors->first('MemberID') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="BorrowDate" class="form-label">Borrow Date</label>
                <input type="date" name="BorrowDate" id="BorrowDate" value="{{ old('BorrowDate')}}"
                  class="form-control{{ $errors->has('BorrowDate') ? ' is-invalid' : '' }}">
                @if ($errors->has('BorrowDate'))
                <span class="text-danger">
                  {{ $errors->first('BorrowDate') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="DueDate" class="form-label">Due Date</label>
                <input type="date" name="DueDate" id="DueDate" value="{{ old('DueDate')}}"
                  class="form-control{{ $errors->has('DueDate') ? ' is-invalid' : '' }}">
                @if ($errors->has('DueDate'))
                <span class="text-danger">
                  {{ $errors->first('DueDate') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="ReturnedDate" class="form-label">Returned Date</label>
                <input type="date" name="ReturnedDate" id="ReturnedDate" value="{{ old('ReturnedDate')}}"
                  class="form-control{{ $errors->has('ReturnedDate') ? ' is-invalid' : '' }}">
                @if ($errors->has('ReturnedDate'))
                <span class="text-danger">
                  {{ $errors->first('ReturnedDate') }}
                </span>
                @endif
              </div>
              <div class="d-flex justify-content-end my-4 gap-3">
                <a href="{{ route('borrowings.index') }}" class="btn btn-warning">Back</a>
                <button type="submit" class="btn btn-success">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection