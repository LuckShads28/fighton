@extends('layout')

@section('content')
    <div class="container my-4">
        <h4 class="fw-bold text-white ms-2">Pengaturan Akun</h4>
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

                <form action="{{ route('profile.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama-organizer" class="form-label text-white-half">
                            Nickname
                        </label>
                        <input type="text" class="form-control search-input-custom" name="nickname"
                            value="{{ $data->nickname }}" />
                    </div>
                    <div class="mb-3">
                        <label for="about" class="form-label text-white-half">
                            Role
                        </label>
                        <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                            style="border:none" required name="role">
                            <option value="Duelist" selected>Duelist</option>
                            <option value="Initiator">Initiator</option>
                            <option value="Controller">Controller</option>
                            <option value="Sentinel">Sentinel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="input-profile" class="form-label text-white-half">
                            Profile
                        </label>
                        @if ($data->profile_pic)
                            <img class="profile-preview mb-3"
                                style="height: 85px; width: 85px; border-radius: 50%; display: block"
                                src="{{ asset('storage/' . $data->profile_pic) }}" />
                        @else
                            <img class="profile-preview mb-3"
                                style="height: 85px; width: 85px; border-radius: 50%; display: none;" />
                        @endif
                        <input class="form-control form-control-sm search-input-custom" name="profile_pic" type="file"
                            onchange="previewImg('profile')" id="profile_img" id="input-profile" />
                    </div>
                    <div class="mb-3">
                        <label for="input-profile" class="form-label text-white-half">
                            Background Profile
                        </label>
                        @if ($data->banner_img)
                            <img src="{{ asset('storage/' . $data->banner_img) }}"
                                class="banner-preview mb-3 img-fluid w-100"
                                style="height: 350px; object-fit: cover; display: block" />
                        @else
                            <img class="banner-preview mb-3 img-fluid w-100"
                                style="height: 350px; object-fit: cover; display: none" />
                        @endif
                        <input class="form-control form-control-sm search-input-custom" name="bg_pic" type="file"
                            onchange="previewImg('banner')" id="banner_img" />
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('profile.index') }}" class="btn btn-custom-cancel">Batal</a>
                        <button type="submit" class="btn btn-custom">Edit Profile</button>
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
