<!DOCTYPE html>

<html>

    <head>

        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/normalize.css">
        <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/style.css">
        <title>beer api developers</title>

    </head>

    <body>

        <header>
            <h1><a href="{{ URL::to('/') }}/v1/docs">beer api developers</a></h1>
        </header>

        <div class="content">

            @yield('content')

        </div>

    </body>

</html>