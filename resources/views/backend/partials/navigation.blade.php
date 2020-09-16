<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="media user-profile mt-2 mb-2">
        <div class="media-body">
            <h6 class="pro-user-name mt-0 mb-0">{{ \Auth::user()->name }}</h6>
            <span class="pro-user-desc">{{ \Auth::user()->role }}</span>
        </div>
    </div>

    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li class="menu-title">Contributeurs</li>
                <li>
                    <a class="{{ \Request::is('backend/arret') || \Request::is('backend/arret/*') ? 'active'  : '' }}" href="{{ secure_url('backend/arret') }}"><i class="fas fa-file-edit"></i><span> Arrêts résumés</span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a class="{{ \Request::is('backend/arret') ? 'active': '' }}" href="{{ secure_url('backend/arret') }}">Liste des arrêts</a></li>
                        <li><a class="{{ \Request::is('backend/arret/create') ? 'active': '' }}" href="{{ secure_url('backend/arret/create') }}">Ajouter arrêt</a></li>
                    </ul>
                </li>
                <li>
                    <a class="{{ \Request::is('backend/theme') || \Request::is('backend/theme/*') ? 'active' : '' }}" href="{{ secure_url('backend/theme') }}"><i class="fas fa-tags"></i><span> Domaines du droit</span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a class="{{ \Request::is('backend/theme/create') ? 'active': '' }}" href="{{ secure_url('backend/theme/create') }}">Ajouter domaine</a></li>
                    </ul>
                </li>
                @if(\Auth::user()->roles->contains('id',1))
                    <li><hr></li>
                    <li class="menu-title">Administrateur</li>
                    <li>
                        <a class="{{ \Request::is('backend/codes') || \Request::is('backend/code/*') ? 'active' : '' }}" href="{{ secure_url('backend/codes') }}"><i class="fas fa-lock"></i><span> Code d'accès</span></a>
                    </li>
                    <li>
                        <a class="{{ \Request::is('backend/decision/*') || \Request::is('backend/archive') ? 'active': '' }}" href="{{ secure_url('backend/decision') }}"><i class="fas fa-gavel"></i><span> Décisions TF </span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a class="{{ \Request::is('backend/decision') ? 'active': '' }}" href="{{ secure_url('backend/decision') }}">Dernières décisions</a></li>
                            <li><a class="{{ \Request::is('backend/archive') ? 'active': '' }}" href="{{ secure_url('backend/archive') }}">Archives</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="{{ \Request::is('backend/user/*') || \Request::is('backend/users') ? 'active' : '' }} " href="{{ secure_url('backend/user') }}"><i class="fas fa-users"></i><span> Utilisateurs </span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a class="{{ \Request::is('backend/user') || \Request::is('backend/users/inactive') ? 'active': '' }}" href="{{ secure_url('backend/user') }}">Gestion</a></li>
                            <li><a class="{{ \Request::is('backend/users/alerte') ? 'active': '' }}" href="{{ secure_url('backend/users/alerte') }}">Alertes</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="{{ \Request::is('backend/newsletter/*') ? 'active' : '' }}" href="{{ secure_url('backend/newsletter') }}"><i class="fas fa-paper-plane"></i><span> Newsletter</span></a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
