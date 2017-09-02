<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('settings.title') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body{!! session('flash') ? ' data-flash-class="'.session('flash.0').'" data-flash-message="'.session('flash.1').'"' : '' !!}>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">{{ config('settings.title') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ml-auto">
                @if(config('owl.allow.frontend'))
                    <li class="nav-item{{ request()->is('/') ?  ' active' : '' }}"><a class="nav-link" href="{{ route('index') }}">Home</a></li>
                @endif
                @if(auth()->guest())
                    <li class="nav-item{{ request()->is('login') ?  ' active' : '' }}"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @if(config('owl.allow.registration'))
                        <li class="nav-item{{ request()->is('register') ?  ' active' : '' }}"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                @else
                    <li class="nav-item{{ request()->is('dashboard') ?  ' active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <!-- crud_navbar -->
                    @canany('Update Settings', 'View Roles', 'View Users')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Manage</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('Update Settings')<a class="dropdown-item{{ request()->is('settings') ?  ' active' : '' }}" href="{{ route('settings') }}">Settings</a>@endcan
                                @can('View Roles')<a class="dropdown-item{{ request()->is('roles') ?  ' active' : '' }}" href="{{ route('roles') }}">Roles</a>@endcan
                                @can('View Users')<a class="dropdown-item{{ request()->is('users') ?  ' active' : '' }}" href="{{ route('users') }}">Users</a>@endcan
                            </div>
                        </li>
                    @endcanany
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-user-circle-o"></i> {{ auth()->user()->name }}</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item{{ request()->is('profile') ?  ' active' : '' }}" href="{{ route('profile') }}">Profile</a>
                            <a class="dropdown-item{{ request()->is('password') ?  ' active' : '' }}" href="{{ route('password') }}">Password</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer>
    <div class="container">
        @if (config('owl.allow.contact'))
            <a href="{{ route('contact') }}" class="pull-right text-secondary">Contact</a>
        @endif
        <span class="text-secondary">&copy;{{ date('Y', time()) }}</span> <a href="{{ route('index') }}" class="text-secondary">{{ config('settings.title') }}</a>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/owl.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>