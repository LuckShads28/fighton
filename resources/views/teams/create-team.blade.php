@extends('layout')

@section('content')
    <div class="container my-4">
        <h4 class="fw-bold text-white ms-3">Tim Baru</h4>
        @if (session()->has('errors'))
            @foreach (session('errors')->all() as $e)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ $e }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <div class="form-border p-4">
            <p class="text-white-half">
                Buat tim baru untuk mengikuti turnamen. Setelah membuat tim. Invite
                teman anda dengan link untuk masuk ke tim anda
            </p>

            <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama-tim" class="form-label text-white-half">
                        Nama Tim
                    </label>
                    <input type="text" class="form-control search-input-custom" id="nama-tim" name="name" required />
                </div>
                <div class="mb-3">
                    <label for="deskripsi-tim" class="form-label text-white-half">Deskripsi Tim (Max: 200 Karakter)
                    </label>
                    <textarea class="form-control search-input-custom" id="deskripsi-tim" rows="2" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="input-profile" class="form-label text-white-half">
                        Upload logo tim
                    </label>
                    <img class="logo-preview mb-3" style="height: 85px; width: 85px; border-radius: 50%; display: none;" />
                    <input class="form-control form-control-sm search-input-custom" id="logo_img" type="file"
                        name="logo_img" onchange="previewImg('logo')" />
                </div>
                <div class="mb-3">
                    <label for="input-profile" class="form-label text-white-half">
                        Upload banner tim
                    </label>
                    <img class="banner-preview mb-3 img-fluid w-100"
                        style="height: 350px; object-fit: cover; display: none" />
                    <input class="form-control form-control-sm search-input-custom" id="banner_img" type="file"
                        name="banner_img" onchange="previewImg('banner')" />
                </div>
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('profile.index') }}" class="btn btn-custom-cancel">Batal</a>
                    <button type="submit" class="btn btn-custom">Buat Tim</button>
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
