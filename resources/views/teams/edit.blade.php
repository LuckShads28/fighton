@extends('layout')

@section('content')
    <div class="container mt-5 my-5">
        {{-- Route::currentRouteName() --}}
        <div class="row">
            {{-- Sidebar --}}
            @include('partials.teams-sidebar')

            {{-- Content --}}
            <div class="col-12 col-md-10">
                <h1 class="text-white">{{ $title }}</h1>
                <div class="card mt-3 bg-custom-primary-2">
                    <div class="card-body">
                        <form action="{{ route('team.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="nama-tim" class="form-label text-white-half">
                                    Nama Tim
                                </label>
                                <input type="text" class="form-control search-input-custom" id="nama-tim" name="name"
                                    required value="{{ $data->name }}" />
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi-tim" class="form-label text-white-half">Deskripsi Tim (Max: 200
                                    Karakter)
                                </label>
                                <textarea class="form-control search-input-custom" id="deskripsi-tim" rows="2" name="description" required>{{ $data->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="input-profile" class="form-label text-white-half">
                                    Upload logo tim
                                </label>
                                @if ($data->logo_img)
                                    <img src="{{ asset('storage/' . $data->logo_img) }}" class="logo-preview mb-3"
                                        style="height: 85px; width: 85px; border-radius: 50%; display: block;" />
                                @else
                                    <img class="logo-preview mb-3"
                                        style="height: 85px; width: 85px; border-radius: 50%; display: none;" />
                                @endif
                                <input class="form-control form-control-sm search-input-custom" id="logo_img"
                                    type="file" name="logo_img" onchange="previewImg('logo')" />
                            </div>
                            <div class="mb-3">
                                <label for="input-profile" class="form-label text-white-half">
                                    Upload banner tim
                                </label>
                                @if ($data->banner_img)
                                    <img src="{{ asset('storage/' . $data->banner_img) }}"
                                        class="banner-preview mb-3 img-fluid w-100"
                                        style="height: 350px; object-fit: cover;" />
                                @else
                                    <img class="banner-preview mb-3 img-fluid w-100"
                                        style="height: 350px; object-fit: cover; display: none" />
                                @endif
                                <input class="form-control form-control-sm search-input-custom" id="banner_img"
                                    type="file" name="banner_img" onchange="previewImg('banner')" />
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('team.show', $slug) }}" class="btn btn-custom-cancel">Batal</a>
                                <button type="submit" class="btn btn-custom">Buat Tim</button>
                            </div>
                        </form>
                    </div>
                </div>
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
