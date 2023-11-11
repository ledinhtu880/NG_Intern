@extends('layouts.master')

@section('title', 'Borrowings Management System')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card mt-3">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title m-0">Manage Borrowing</h3>
            <a href="{{ route('borrowings.create') }}" class="btn btn-success p-2">
              <i class="fa-solid fa-plus rounded-circle p-1 bg-light text-success me-1"></i>
              Add new Borrowing
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-hover table-striped mb-0">
            <thead>
              <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Book</th>
                <th class="text-center" scope="col">Member ID</th>
                <th class="text-center" scope="col">Borrow Date</th>
                <th class="text-center" scope="col">Borrow Date</th>
                <th class="text-center" scope="col">Due Date</th>
                <th class="text-center" scope="col">Action</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              @foreach($borrowings as $borrowing)
              <tr>
                <td scope="col" class="text-center">{{ $borrowing->BorrowingID}}</td>
                <td class="text-center">{{ $borrowing->book_title}}</td>
                <td class="text-center">{{ $borrowing->MemberID}}</td>
                <td class="text-center">{{ $borrowing->borrow_time}}</td>
                <td class="text-center">{{ $borrowing->due_time}}</td>
                <td class="text-center">{{ $borrowing->returned_time}}</td>
                <td class="text-center">
                  <a href="{{ route('borrowings.show', $borrowing->BorrowingID ) }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('borrowings.edit', $borrowing->BorrowingID ) }}" class="btn btn-sm btn-warning">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                    data-bs-target="#deleteModal-{{ $borrowing->BorrowingID }}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="deleteModal-{{ $borrowing->BorrowingID }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete this borrowing?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form action="{{route('borrowings.destroy', $borrowing->BorrowingID)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if ($borrowings->lastPage() > 1)
        <div class="card-footer">
          <div class="paginate">
            {{ $borrowings->links('pagination::bootstrap-5')}}
          </div>
        </div>
        @endif
      </div>
      @if(session('message') && session('type'))
      <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
            <div class=" d-flex justify-content-center align-items-center gap-2">
              @if(session('type') == 'success')
              <i class="fas fa-check-circle text-light fs-5"></i>
              @elseif(session('type') == 'danger')
              <i class="fas fa-xmark-circle text-light fs-5"></i>
              @elseif(session('type') == 'info' || session('type') == 'secondary')
              <i class="fas fa-info-circle text-light fs-5"></i>
              @endif
              <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();
  })
</script>
@endsection