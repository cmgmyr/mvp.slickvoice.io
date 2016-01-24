<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SlickVoice</title>
    @yield('meta')

    <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
    @include('layouts.partials.favicon')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}">SlickVoice</a>
            </div>

            <div id="navbar" class="collapse navbar-collapse">
                @if($currentUser)
                @include('layouts.partials.navigation')
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" name="user-dropdown">
                            <img class="avatar nav-avatar img-circle" src="{{$currentUser->avatar}}" alt="{{$currentUser->name}}">
                            {{ $currentUser->name}} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @include('layouts.partials.navigation-dropdown')
                        </ul>
                    </li>
                </ul>
                @else
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Log in</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('common.flash')
                <h1 class="page-header">@yield('title')</h1>
                @yield('content')
                @yield('pagination')
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-muted">
            <ul class="list-inline">
                <li>Copyright &copy; <a href="https://github.com/cmgmyr" target="_blank">Chris Gmyr</a></li>
            </ul>
        </div>
    </footer>

    <script src="{{ elixir("js/app.js") }}"></script>
    @yield('scripts')
    @include('layouts.partials.ga')
</body>
</html>
