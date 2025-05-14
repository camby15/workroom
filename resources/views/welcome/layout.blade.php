<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="WorkRoom" name="description" />
        <meta content="WorkRoom" name="Wi Tech" />
        <title>WorkRoom</title>
        <link rel="stylesheet" href="{{ asset('style/style.css') }}" />
        <!-- webpage logo icon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images/WRLogo.jpg') }}" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
            rel="stylesheet" />
    </head>
    <body>
        @include('welcome.navbar')

        @yield('content')

        <script src="https://kit.fontawesome.com/f0f7be09c0.js" crossorigin="anonymous"></script>
        <script src="{{ asset('style/script.js') }}"></script>
    </body>
</html>
