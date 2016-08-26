<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kleis</title>
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/vendor/bootstrap-iconpicker.min.css" rel="stylesheet">

    <!-- JavaScripts -->
    <script src="/js/vendor.js" type="text/javascript" language="javascript"></script>
    <script src="/js/vendor/iconset-fontawesome-4.2.0.min.js" type="text/javascript" language="javascript"></script>
    <script src="/js/vendor/bootstrap-iconpicker.min.js" type="text/javascript" language="javascript"></script>
    <script src="/js/app.js" type="text/javascript" language="javascript"></script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default"></nav>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                @if (Auth::user())
                    <a class="navbar-brand" href="{{ url('/home') }}">Kleis</a>
                @else
                    <a class="navbar-brand" href="{{ url('/') }}">Kleis</a>
                @endif
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::user())
                        <li><a href="{{ url('/home') }}">Accueil</a></li>
                        <li><a href="{{ url('/accounts') }}">Comptes</a></li>
                        @if (Auth::user()->level > 1)
                            <li><a href="{{ url('/groups') }}">D&eacute;l&eacute;gations</a></li>
                            @if (Auth::user()->level == 9)
                                <li><a href="{{ url('/categories') }}">Cat&eacute;gories</a></li>
                            @endif
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Listes Blanches <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ url('/whitelist/domains') }}"><i class="fa fa-btn fa-globe"></i>Domaines</a></li>
                                <li><a href="{{ url('/whitelist/urls') }}"><i class="fa fa-btn fa-link"></i>URLs</a></li>
                              </ul>
                            </li>
                        @endif
                        @if (Auth::user()->level == 9)
                            <li><a href="{{ url('/administrators') }}">Administrateurs</a></li>
                        @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::user())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->firstname }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Mon compte</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>D&eacute;connexion</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
