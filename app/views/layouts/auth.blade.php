<!DOCTYPE html>

<html>

    <head>

        <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/normalize.css">
        <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/style.css">
        <title>Login to Beer API</title>

    </head>

    <body>

        <header>
            <h1>beer api authentication</h1>
        </header>

        <div class="content">

            @yield('content')

        </div>

    </body>

</html>