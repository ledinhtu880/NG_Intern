@extends('layouts.master')

@section('title', 'Borrowing Details')

@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12 d-flex align-items-center justify-content-center">
      <div class="card border-0 shadow overflow-hidden" style="width: 650px">
        <div class="row g-0">
          <div class="card-body d-flex flex-column justify-content-between h-100">
            <div class="row">
              <h4 class="h4 card-title border-bottom mb-3">Book Information</h4>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Book Title</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $book->Title }}</h6>
              </div>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Book Author</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $book->Author }}</h6>
              </div>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Genre</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $book->Genre }}</h6>
              </div>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Book Published</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $book->PublishedYear }}</h6>
              </div>
            </div>
            <div class="row">
              <h5 class="h5 card-title border-bottom mb-3">Borrowing Information</h5>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Member ID</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $borrowing->MemberID }}</h6>
              </div>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Borrow Date</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $borrowing->borrow_time }}</h6>
              </div>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Due Date</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $borrowing->due_time }}</h6>
              </div>
              <div class="col-md-6">
                <h5 class="h5 fw-medium mb-1">Returned Date</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $borrowing->returned_time }}</h6>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-end align-items-center gap-2">
                  <a href="{{ route('borrowings.index') }}" class="btn btn-warning">Back</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection