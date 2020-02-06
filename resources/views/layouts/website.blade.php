<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
</head>

<body>
    <header>
        <nav class="navbar navbar-dark fixed-top bg-dark text-algin-center">
            <div class="col-12 align-self-center">
                <div class="text-light text-center">
                    @yield('title')
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5 mb-5">
        @yield('content')
    </div>

    <nav class="navbar fixed-bottom navbar-light bg-light">
        <div class="col-6 align-self-center">
            <div class="text-light text-center">
                <a class="navbar-brand" href="#">My Favorite</a>
            </div>
        </div>
        <div class="col-6 align-self-center">
            <div class="text-light text-center">
                <a class="navbar-brand" href="{{route('categories')}}">Library</a>
            </div>
        </div>
    </nav>

    @yield('scripts')
</body>
</html>
