<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="#">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo/teh_poci.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    @stack('styles')
</head>

<body>
    <div class="container">
        <div class="text-center">
            @php
                // if (isset(auth()->user()->akses)) {
                //     if (auth()->user()->akses == 'admin') {
                //         $halaman = route('admin.index');
                //     } else {
                //         $halaman = route('transaksi.home');
                //     }
                // } else {
                //     $halaman = route('login');
                // }
            @endphp
            <a href="{{ route('admin.index') }}">
                <img src="{{ asset('logo/teh_poci.png') }}" width="50px" class="p-0 my-2">
            </a>
        </div>
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @if (session('status'))
        <script>
            Swal.fire({
                position: 'top',
                icon: "{{ session('status')[0] }}",
                title: "{{ session('status')[1] }}",
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
    @stack('scripts')
</body>

</html>
