@extends('layout')

@section('content')
    @push('css')
        {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/adminlte/plugins/summernote/summernote-bs5.min.css"> --}}
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    @endpush
    <div class="container mt-5 mt-md-0 p-md-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="ms-2 mb-1">
                <h4 class="fw-bold text-white">Edit Turnamen</h4>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-dark-custom dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Basic
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
        <div class="p-3 bg-custom-primary rounded">
            @if (session()->has('errors'))
                @foreach (session('errors')->all() as $e)
                    <p class="text-white">{{ $e }}</p>
                @endforeach
            @endif
            <form action="{{ route('tournament.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="orgSlug" value="{{ $data->organizer->slug }}">
                {{-- <input type="hidden" name="id" value="{{ $tournamentData->id }}"> --}}
                <div class="my-2">
                    <div class="p-3 bg-custom-primary rounded" id="info-basic">
                        <div class="mb-3">
                            <label for="nama-tim" class="form-label text-white-half">
                                Nama Turnamen
                            </label>
                            <input type="text" class="form-control search-input-custom" id="nama-tim" name="name"
                                required value="{{ $data->name }}" />
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="tanggal" class="form-label text-white-half">
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-control search-input-custom" id="tanggal"
                                        name="start_date" required value="{{ $data->start_date }}" />
                                </div>
                                <div class="col-6">
                                    <label for="waktu" class="form-label text-white-half">
                                        Waktu Mulai
                                    </label>
                                    <input type="time" class="form-control search-input-custom" id="waktu"
                                        name="start_time" required value="{{ $data->start_time }}" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="tanggal" class="form-label text-white-half">
                                        Slot Tim
                                    </label>
                                    <input type="text" class="form-control search-input-custom" id="slot-tim"
                                        name="team_slot" required value="{{ $data->team_slot }}" />
                                </div>
                                <div class="col-6">
                                    <label for="waktu" class="form-label text-white-half">
                                        PrizePool
                                    </label>
                                    <input type="text" class="form-control search-input-custom" id="Prizepool"
                                        name="prizepool" required value="{{ $data->prizepool }}" />
                                </div>
                                <div class="mb-3">
                                    <label for="rules" class="form-label text-white-half">
                                        Rules
                                    </label>
                                    <textarea class="form-control search-input-custom" rows="5" name="rules" required>{{ $data->rules }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label text-white-half">
                                        Tentang Turnamen
                                    </label>
                                    {{-- <input type="hidden" id="about" name="about" value="{{ $data->about }}"> --}}
                                    {{-- <trix-editor class="search-input-custom" input="about"></trix-editor> --}}
                                    <textarea class="form-control search-input-custom" rows="5" name="about" required>{{ $data->about }}</textarea>
                                    {{-- <textarea class="form-control search-input-custom" name="about" id="summernote" cols="30" rows="10">{{ $data->about }}</textarea> --}}
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label text-white-half">
                                        Kategori Tim
                                    </label>
                                    <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                                        style="border:none" required name="team_category">
                                        <option value="5v5" {{ $data->team_category == '5v5' ? 'selected' : '' }}>5v5
                                        </option>
                                        <option value="4v4" {{ $data->team_category == '4v4' ? 'selected' : '' }}>4v4
                                        </option>
                                        <option value="3v3" {{ $data->team_category == '3v3' ? 'selected' : '' }}>3v3
                                        </option>
                                        <option value="2v2" {{ $data->team_category == '2v2' ? 'selected' : '' }}>2v2
                                        </option>
                                        <option value="1v1" {{ $data->team_category == '1v1' ? 'selected' : '' }}>1v1
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label text-white-half">
                                        Jenis Pendaftaran
                                    </label>
                                    <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                                        style="border:none" required name='tournament_type'>
                                        <option value="auto_join"
                                            {{ $data->tournament_type == 'auto_join' ? 'selected' : '' }}>Langsung Diterima
                                        </option>
                                        <option value="need_confirm"
                                            {{ $data->tournament_type == 'need_confirm' ? 'selected' : '' }}>Menunggu
                                            Konfirmasi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="banner_pic" class="form-label text-white-half">
                                        Header Banner
                                    </label>
                                    <img src="{{ asset('storage/' . $data->banner_pic) }}"
                                        class="banner-preview mb-3 img-fluid w-100"
                                        style="height: 350px; object-fit: cover; display: block" />
                                    <input type="file" class="form-control search-input-custom" name="banner_pic"
                                        onchange="previewImg()" id='banner_pic' />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3 gap-3">
                    <a href="{{ route('organizer_tournaments', $data->organizer->slug) }}"
                        class="btn btn-custom-cancel">Batal</a>
                    <button type="submit" class="btn btn-custom">Edit Turnamen</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImg() {
            const image = document.querySelector('#banner_pic');
            const imgPreview = document.querySelector('.banner-preview')

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>

    @push('script')
        {{-- <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script> --}}
        {{-- <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/summernote/summernote.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#summernote').summernote();
            });
        </script> --}}
    @endpush
@endsection
