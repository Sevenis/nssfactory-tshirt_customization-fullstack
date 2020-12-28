<nav class="nav-container">
    <div class="container-center">
        <div class="nav">
            <div class="nav__logo">
                <a href="{{ route('home') }}">
                    <img src="https://www.nssfactory.com/assets/extensions/nss/images/logo.png"
                        alt="nssfactory_logo">
                </a>
            </div>

            <div class="nav__user">
                <div class="nav__user">
                    <div class="nav__user-box">
                        <div class="nav__user-button">
                            <img src="https://a0.muscache.com/defaults/user_pic-50x50.png?v=3" alt="">
                        </div>
                        <div class="nav__user-hamburger">
                            <i class="fas fa-bars"></i>
                        </div>
                    </div>
                    <ul class="nav__user__menu">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav__user__menu-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav__user__menu-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="user-greetings">

                                   Ciao {{ Auth::user()->name }}

                            </li>

                            <li class="nav__user__menu-item">
                                <input id="nav_user-id" type="hidden" value="{{Auth::user()->id}}">
                                <a href="{{route('user.index')}}" class="nav-link">I tuoi progetti</a>
                            </li>
                            <li class="nav__user__menu-item">
                              <a href="{{route('user.create')}}" class="nav-link">Nuovo progetto</a>
                            </li>
                            <li class="nav__user__menu-item">

                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
