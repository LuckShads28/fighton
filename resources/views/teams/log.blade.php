@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            {{-- Sidebar --}}
            @include('partials.teams-sidebar')

            {{-- Content --}}
            <div class="col-12 col-md-10">
                <h1 class="text-white">{{ $title }}</h1>
                <div class="card bg-dark-custom text-white">
                    <div class="card-body">
                        @foreach ($logData as $l)
                            <hr>
                            <p>{{ $l->action }}</p>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeSlot" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark-custom">
                <div class="modal-header" style="border: none">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        onclick="clearModal()"></button>
                </div>
                <div class="modal-body text-white">
                    <form action="{{ route('change_slot', $data->slug) }}" method="post">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="userSlug" id="userSlug" value="">
                            <div class="col">
                                <label for="#">Nickname</label>
                                <input type="text" class="form-control search-input-custom" disabled name="nickname"
                                    id="nickname" value="">
                            </div>
                            <div class="col">
                                <label for="#">Slot</label>
                                <select class="form-select bg-custom-2 text-white" aria-label="Default select example"
                                    style="border:none" name="slot" required>
                                    <option value="">Pilih Slot</option>
                                    <option value="initiator">Inititator</option>
                                    <option value="controller">Controller</option>
                                    <option value="duelist">Duelist</option>
                                    <option value="sentinel">Sentinel</option>
                                    <option value="player_5">Fleksibel</option>
                                    <option value="sub_1">Cadangan 1</option>
                                    <option value="sub_2">Cadangan 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-3" id="submitBtn">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function clearModal() {
            document.getElementById('userSlug').value = '';
            document.getElementById('nickname').value = '';
        }

        function changeSlot(slug, nickname) {
            document.getElementById('userSlug').value = slug;
            document.getElementById('nickname').value = nickname;
        }
    </script>
@endsection
