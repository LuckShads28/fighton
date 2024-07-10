@extends('layout')

@section('content')
    <div class="container my-4">
        <h4 class="fw-bold text-white ms-2">Organizer Baru</h4>
        <div class="p-3 bg-custom-primary rounded">
            <p class="text-white-half">
                Buat organizer baru untuk membuat dan mengatur turnamen. Anda dapat
                invite teman anda menjadi anggota dari organizer anda.
            </p>

            @if (session()->has('errors'))
                @foreach (session('errors')->all() as $e)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal!</strong> {{ $e }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif

            <form action="{{ route('organizer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama-organizer" class="form-label text-white-half">
                        Nama Organizer
                    </label>
                    <input type="text" class="form-control search-input-custom" name="name" />
                </div>
                <div class="mb-3">
                    <label for="deskripsi-organizer" class="form-label text-white-half">Deskripsi Organizer (Max: 200
                        Karakter)
                    </label>
                    <textarea class="form-control search-input-custom" name="description" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="Kontak" class="form-label text-white-half">Kontak</label>
                    <textarea class="form-control search-input-custom" name="contact" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="input-profile" class="form-label text-white-half">
                        Logo Organizer
                    </label>
                    <img class="logo-preview mb-3" style="height: 85px; width: 85px; border-radius: 50%; display: none;" />
                    <input class="form-control form-control-sm search-input-custom" name="logo_img" type="file"
                        onchange="previewImg('logo')" id="logo_img" />
                </div>
                <div class="mb-3">
                    <label for="input-profile" class="form-label text-white-half">
                        Banner Organizer
                    </label>
                    <img class="banner-preview mb-3 img-fluid w-100"
                        style="height: 350px; object-fit: cover; display: none" />
                    <input class="form-control form-control-sm search-input-custom" name="banner_img" type="file"
                        onchange="previewImg('banner')" id="banner_img" />
                </div>
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('organizer.index') }}" class="btn btn-custom-cancel">Batal</a>
                    <button type="submit" class="btn btn-custom">Buat organizer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImg(img) {
            const image = document.querySelector('#' + img + '_img');
            const imgPreview = document.querySelector('.' + img + '-preview')

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
