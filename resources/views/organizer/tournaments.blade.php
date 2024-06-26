@extends('organizer.layout')

@section('content')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('/') }}assets/vendor/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-custom-primary-2">
                    <div class="card-body">
                        <div class="row my-3">
                            <div class="col-9">
                                <form action="{{ Route::current()->url }}">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search"
                                            class="form-control float-right search-input-custom" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"
                                                style="background-color: #343434; border: none">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-3">
                                <form action="{{ route('tournament.create') }}" class="ms-auto">
                                    <input type="hidden" name="orgSlug" value="{{ $organizerData->slug }}">
                                    <button type="submit" class="btn btn-custom">Buat Turnamen</button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">#</th>
                                    <th>Nama Turnamen</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tournaments->count() > 0)
                                    @foreach ($tournaments as $t)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $t->name }}</td>
                                            <td>Belum Selesai</td>
                                            <td style="width: 170px">
                                                <div class="row">
                                                    <a href="{{ route('tournament.edit', $t->slug) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('tournament.destroy', $t->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="orgSlug"
                                                            value="{{ $t->organizer->slug }}">
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada turnamen</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{ $tournaments->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
@endsection
