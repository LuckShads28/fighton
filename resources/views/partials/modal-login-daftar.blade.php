<div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark-custom">
            <div class="modal-header" style="border: none">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ps-3 pe-3 pb-3">
                    @if (session()->has('errors'))
                        @if ($errors->register->any())
                            @foreach ($errors->register->all() as $e)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Gagal!</strong> {{ $e }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endforeach
                        @else
                            @foreach (session('errors')->all() as $e)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Gagal!</strong> {{ $e }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endforeach
                        @endif
                    @endif
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="custom-login-tab" role="tablist">
                            <button class="nav-link {{ $errors->register->any() ? '' : 'active' }}" id="nav-login-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-login" type="button" role="tab"
                                aria-controls="nav-login" aria-selected="true">
                                Login
                            </button>
                            <button class="nav-link {{ $errors->register->any() ? 'active' : '' }}"
                                id="nav-register-tab" data-bs-toggle="tab" data-bs-target="#nav-register" type="button"
                                role="tab" aria-controls="nav-register" aria-selected="false">
                                Register
                            </button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade {{ $errors->register->any() ? '' : 'show active' }}" id="nav-login"
                            role="tabpanel" aria-labelledby="nav-login-tab" tabindex="0">
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white-half">Email address</label>
                                    <input type="email" class="form-control search-input-custom" id="email"
                                        aria-describedby="emailHelp" required name='email' />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-white-half">Password</label>
                                    <input type="password" class="form-control search-input-custom" name='password'
                                        id="password" required />
                                </div>
                                <div class="mb-4 form-check d-flex justify-content-between">
                                    <div>
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                                        <label class="form-check-label text-white-half" for="exampleCheck1">Remember
                                            Me</label>
                                    </div>
                                    <a href="#" class="nav-link text-white-half">Lupa
                                        Password?</a>
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-custom ms-auto">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ $errors->register->any() ? 'show active' : '' }}" id="nav-register"
                            role="tabpanel" aria-labelledby="nav-register-tab" tabindex="0">
                            <form action="{{ route('register') }}" method='POST'>
                                @csrf
                                <div class="mb-3">
                                    <label for="text" class="form-label text-white-half">Nickname</label>
                                    <input type="text" class="form-control search-input-custom" id="nickname"
                                        name='nickname' aria-describedby="nicknameHelp" />
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white-half">Email</label>
                                    <input type="email"
                                        class="form-control search-input-custom {{ $errors->register->has('email') ? 'is-invalid' : '' }}"
                                        id="email" name='email' aria-describedby="emailHelp" />
                                    @if ($errors->register->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->register->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label text-white-half">Password</label>
                                    <input type="password" class="form-control search-input-custom " id="password"
                                        name='password' />
                                </div>
                                <div class="mb-4">
                                    <label for="konfirmasi-password" class="form-label text-white-half">Konfirmasi
                                        Password</label>
                                    <input type="password" class="form-control search-input-custom "
                                        id="konfirmasi-password" name='confirm_password' />
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-custom ms-auto" type="submit">Daftar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
