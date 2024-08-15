<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - The Kost</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body id="custom-body">
    <div class="container">
        <div class="card mt-5">
            @yield('content')
        </div>

    </div>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <scipt src="{{ asset('assets/js/bootstrap.js') }}"></scipt>
    <scipt src="{{ asset('assets/js/app.js') }}"></scipt>
</body>

</html>
