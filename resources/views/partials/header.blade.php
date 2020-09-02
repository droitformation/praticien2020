<nav class="main-nav-one">
    <div class="container">
        <div class="inner-container">
            <div class="logo-box">
                <a class="logo" href="{{ secure_url('/') }}"><strong>Droit</strong> <span>pour le praticien</span></a>
            </div><!-- /.logo-box -->
            <div class="main-nav__main-navigation">
                <ul class="main-nav__navigation-box">
                    <li><a href="{{ secure_url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Accueil</a></li>
                    <li><a href="{{ secure_url('about') }}" class="{{ Request::is('about') ? 'active' : '' }}">A propos</a></li>
                    <li><a href="{{ secure_url('arrets') }}" class="{{ Request::is('arrets') || Request::is('theme/*') || Request::is('subtheme/*') ? 'active' : '' }}">Arrêts résumés</a></li>
                    <li><a href="{{ secure_url('decisions') }}" class="{{ Request::is('decisions') || Request::is('decision/*') ? 'active' : '' }}">TF - Jurisprudence</a></li>
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
            <div class="main-nav__main-navigation main-nav__right">
                <a href="#" class="search-popup__toggler"><i class="muzex-icon-search"></i></a>
                @auth()
                <ul class="main-nav__navigation-box pl-5">
                   <li class="dropdown">
                       <a href="{{ secure_url('home') }}" class=""><i class="fas fa-user"></i></a>
                       <ul class="right">
                           <li><a href="{{ secure_url('home') }}">Compte</a></li>
                           <li><a href="{{ secure_url('abos') }}">Abonnements</a></li>
                           <li>
                               <form class="logout" action="{{ route('logout') }}" method="POST"> @csrf
                                   <button class="btn btn-default btn-xs" type="submit"><i class="fas fa-power-off"></i> &nbsp;Logout</button>
                               </form>
                           </li>
                       </ul>
                   </li>
                </ul><!-- /.main-nav__navigation-box -->
                @else
                    <a href="{{ secure_url('login') }}" class="thm-btn contact-one__btn login-btn">Login</a>
                @endauth
            </div><!-- /.main-nav__right -->
        </div><!-- /.inner-container -->
    </div><!-- /.container -->
</nav><!-- /.main-nav-one -->
