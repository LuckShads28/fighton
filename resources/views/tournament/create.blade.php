@extends('layout')

@section('content')
    <div class="container mt-5 mt-md-0 p-md-5">
        <div class="ms-2 mb-1">
            <h4 class="fw-bold text-white">Buat Turnamen</h4>
        </div>
        <div class="p-3 bg-custom-primary rounded">
            @if (session()->has('errors'))
                <p class="text-white">error</p>
                @foreach (session('errors')->all() as $e)
                    <p class="text-white">{{ $e }}</p>
                @endforeach
            @endif
            <form action="{{ route('tournament.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="orgId" value="{{ $orgId }}">
                <input type="hidden" name="slug" value="{{ $slug }}">
                <div class="my-2">
                    <div class="p-3 bg-custom-primary rounded" id="info-basic">
                        <div class="mb-3">
                            <label for="nama-tim" class="form-label text-white-half">
                                Nama Turnamen
                            </label>
                            <input type="text" class="form-control search-input-custom" id="nama-tim" name="name"
                                required />
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="tanggal" class="form-label text-white-half">
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-control search-input-custom" id="tanggal"
                                        name="start_date" required />
                                </div>
                                <div class="col-6">
                                    <label for="waktu" class="form-label text-white-half">
                                        Waktu Mulai
                                    </label>
                                    <input type="time" class="form-control search-input-custom" id="waktu"
                                        name="start_time" required />
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
                                        name="team_slot" required />
                                </div>
                                <div class="col-6">
                                    <label for="waktu" class="form-label text-white-half">
                                        PrizePool
                                    </label>
                                    <input type="text" class="form-control search-input-custom" id="Prizepool"
                                        name="prizepool" required />
                                </div>
                                <div class="mb-3">
                                    <label for="rules" class="form-label text-white-half">
                                        Rules
                                    </label>
                                    <textarea class="form-control search-input-custom" rows="5" name="rules" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label text-white-half">
                                        Tentang Turnamen
                                    </label>
                                    <textarea class="form-control search-input-custom" rows="5" name="about" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label text-white-half">
                                        Kategori Tim
                                    </label>
                                    <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                                        style="border:none" required name="team_category">
                                        <option value="5v5" selected>5v5</option>
                                        <option value="4v4">4v4</option>
                                        <option value="3v3">3v3</option>
                                        <option value="2v2">2v2</option>
                                        <option value="1v1">1v1</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label text-white-half">
                                        Jenis Pendaftaran
                                    </label>
                                    <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                                        style="border:none" required name='tournament_type'>
                                        <option value="auto_join" selected>Langsung Diterima</option>
                                        <option value="need_confirm">Menunggu Konfirmasi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="banner_pic" class="form-label text-white-half">
                                        Header Banner
                                    </label>
                                    <img class="banner-preview mb-3 img-fluid w-100"
                                        style="height: 350px; object-fit: cover; display: none" />
                                    <input type="file" class="form-control search-input-custom" name="banner_pic"
                                        required onchange="previewImg()" id="banner_pic" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3 gap-3">
                    <a href="{{ route('organizer_tournaments', $slug) }}" class="btn btn-custom-cancel">Batal</a>
                    <button type="submit" class="btn btn-custom">Buat Turnamen</button>
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
@endsection
