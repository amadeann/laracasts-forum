<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }} {{ app()->version() }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    Browse
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/threads">All Threads</a>
                    @if( auth()->check() )
                        <a class="dropdown-item" href="/threads?by={{ auth()->user()->name }}">My Threads</a>
                    @endif
                    <a class="dropdown-item" href="/threads?popular=1">Popular Threads</a>    
                    <a class="dropdown-item" href="/threads?unanswered=1">Unanswered Threads</a>    
                </div>
            </li>
            <li class="nav-item"><a href="/threads/create" class="nav-link">New Thread</a></li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    Channels
                </a>
                <div class="dropdown-menu">
                    @foreach( $channels as $channel )
                    <a class="dropdown-item" href="/threads/{{ $channel->slug }}">{{ $channel->name }}</a> @endforeach
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            @if (Auth::guest())
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
            @else
                <user-notifications></user-notifications>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('profile', Auth::user()) }}" class="dropdown-item">
                            Profile
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            @endif
        </ul>
    </div>

</nav>