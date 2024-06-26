@extends('layout')

@section('content')
    <div class="container my-4">
        <h4 class="fw-bold text-white ms-2">Edit Organizer</h4>
        <div class="card bg-custom-primary rounded">
            <div class="card-body">
                @if (session()->has('errors'))
                    @foreach (session('errors')->all() as $e)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ $e }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif

                <form action="{{ route('organizer.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama-organizer" class="form-label text-white-half">
                            Nama Organizer
                        </label>
                        <input type="text" class="form-control search-input-custom" name="name"
                            value="{{ $data->name }}" />
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi-organizer" class="form-label text-white-half">Deskripsi Organizer (Max: 200
                            Karakter)
                        </label>
                        <textarea class="form-control search-input-custom" name="description" rows="2">{{ $data->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Kontak" class="form-label text-white-half">Kontak</label>
                        <textarea class="form-control search-input-custom" name="contact" rows="2">{{ $data->contact }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="input-profile" class="form-label text-white-half">
                            Logo Tim
                        </label>
                        @if ($data->logo_img)
                            <img class="logo-preview mb-3"
                                style="height: 85px; width: 85px; border-radius: 50%; display: block"
                                src="{{ asset('storage/' . $data->logo_img) }}" />
                        @else
                            <img class="logo-preview mb-3"
                                style="height: 85px; width: 85px; border-radius: 50%; display: none;" />
                        @endif
                        <input class="form-control form-control-sm search-input-custom" name="logo_img" type="file"
                            onchange="previewImg('logo')" id="logo_img" id="input-profile" />
                    </div>
                    <div class="mb-3">
                        <label for="input-profile" class="form-label text-white-half">
                            Banner Organizer
                        </label>
                        @if ($data->banner_img)
                            <img src="{{ asset('storage/' . $data->banner_img) }}"
                                class="banner-preview mb-3 img-fluid w-100"
                                style="height: 350px; object-fit: cover; display: block" />
                        @else
                            <img class="banner-preview mb-3 img-fluid w-100"
                                style="height: 350px; object-fit: cover; display: none" />
                        @endif
                        <input class="form-control form-control-sm search-input-custom" name="banner_img" type="file"
                            onchange="previewImg('banner')" id="banner_img" />
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('organizer_dashboard', $data->slug) }}" class="btn btn-custom-cancel">Batal</a>
                        <button type="submit" class="btn btn-custom">Edit organizer</button>
                    </div>
                </form>
            </div>
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
