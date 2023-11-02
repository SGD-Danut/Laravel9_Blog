<!DOCTYPE html>
<html>
    <head>
        <title>@yield('pageTitle')</title>
        <!-- Bootstrap: CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ url('css/style.css') }}">
    </head>
    <body>
        <div class="row justify-content-center">
            @yield('navigation')
            <div class="col-md-8">
                <div class="container">
                    <div class="px-4 py-5 my-5 text-center col-lg-8 mx-auto">
                        <img class="d-block mx-auto mb-4" src="https://www.rankmovers.com/wp-content/uploads/2021/09/creer-un-blog.png" alt="" width="250" id="appImage">
                        <h1 class="display-5 fw-bold">Blog</h1>
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.posts') }}">Administrează postări</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('front.all-posts', ['posts' => 'all']) }}">Vezi toate postările</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap: JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
</html>