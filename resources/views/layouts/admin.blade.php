<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>
<body>

    <nav class="navbar navbar-toggleable-md bg-faded">
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
