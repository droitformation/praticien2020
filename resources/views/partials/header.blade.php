<nav class="main-nav-one">
    <div class="container">
        <div class="inner-container">
            <div class="logo-box">
                <a class="logo" href="{{ secure_url('/') }}"><strong>Droit</strong> <span>pour le praticien</span></a>
            </div><!-- /.logo-box -->
            <div class="main-nav__main-navigation">
                <ul class="main-nav__navigation-box">
                    <li><a href="{{ secure_url('/') }}">Accueil</a></li>
                    <li><a href="{{ secure_url('about') }}">A propos</a></li>
                 {{--   <li class="dropdown">
                        <a href="about.html">Votre compte</a>
                        <ul>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="team.html">Team</a></li>
                        </ul>
                    </li>--}}
                    @guest()
                        <li><a href="{{ secure_url('access') }}">Accès</a></li>
                    @endguest
                    <li><a href="{{ secure_url('contact') }}">Contact</a></li>
                </ul><!-- /.main-nav__navigation-box -->
            </div><!-- /.main-nav__main-navigation -->
            <div class="main-nav__right">
                <a href="#" class="search-popup__toggler"><i class="muzex-icon-search"></i></a>
                <a href="{{ secure_url('home') }}" class=""><i class="fas fa-user"></i></a>
            </div><!-- /.main-nav__right -->
        </div><!-- /.inner-container -->
    </div><!-- /.container -->
</nav><!-- /.main-nav-one -->
