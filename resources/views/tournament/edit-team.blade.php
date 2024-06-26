@extends('layout')

@section('content')
    <div class="container mt-5 mt-md-0 p-md-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="ms-2 mb-1">
                <h4 class="fw-bold text-white">Edit Turnamen</h4>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-dark-custom dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Tim
                    </button>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="{{ Route::current()->url }}?page=basic">Basic</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ Route::current()->url }}?page=team">Tim</a></li>
                        <li><a class="dropdown-item" href="{{ Route::current()->url }}?page=match">Pertandingan</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card bg-dark-custom">
            test
        </div>
    </div>
@endsection
