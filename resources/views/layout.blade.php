<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/fontawesome/css/solid.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/custom.css" />
    @stack('css')
    <link rel="icon" type="image/x-icon" href="{{ asset('/') }}assets/img/logo/favicon.ico">
    <title>{{ $title }} | fighton.my.id</title>
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    @yield('content')
    @auth
        @if (!Auth::user()->role)
            <div class="container">
                <div class="alert alert-danger fade show my-3" role="alert">
                    <strong>Peringatan!</strong> anda belum memiliki role, silahkan atur di profile agar bisa mendaftar
                    turnamen
                    atau membuat tim
                </div>
            </div>
        @endif
    @endauth

    @auth
    @else
        @include('partials.modal-login-daftar')
    @endauth

    <!-- Footer -->
    <footer class="footer py-3 bg-custom-primary mt-auto">
        <div class="container">
            <div>
                <a href="#" class="text-white-half ms-auto">FIGHTON</a>
            </div>
        </div>
    </footer>
    <script src="{{ asset('/') }}assets/js/jquery.min.js"></script>
    <script src="{{ asset('/') }}assets/js/popper.min.js"></script>
    <script src="{{ asset('/') }}assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    @stack('script')
    @if (session()->has('errors'))
        <script>
            $(document).ready(function() {
                $('#login').modal('toggle');
            })
        </script>
    @endif
</body>

</html>
