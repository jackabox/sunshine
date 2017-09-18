<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <style>
    a {
        color: #ed4761;
    }

    a:hover, a:focus {
        color: inherit;
        text-decoration: underline;
    }
    .jumbotron {
        background: linear-gradient(45deg, #ed4761 0%, #f58380 100%);
        border-radius: 0;
    }
    .jumbotron * {
        color: white;
    }
    </style>
</head>
<body>

    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <div class="container">
            <h1 class="navbar-brand mb-0">admin</h1>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="/admin/products">Products</a>
                    <a class="nav-item nav-link active" href="/admin/licenses">License</a>
                </div>
            </div>
        </div>
    </nav>

    <br>

    <div class="container">
        <h1>@yield('title')</h1>
        <br>

        @yield('content')
    </div>
</body>
</html>
