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
                    <a {{ \Request::is('backend/arret/*') }} href="{{ secure_url('backend/arret') }}"><i class="fas fa-file-edit"></i><span> Arrêts résumés</span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ secure_url('backend/arret/create') }}">Ajouter arrêt</a></li>
                    </ul>
                </li>
                <li>
                    <a {{ \Request::is('backend/arret/*') || \Request::is('backend/theme') ? : '' }} href="{{ secure_url('backend/theme') }}"><i class="fas fa-tags"></i><span> Domaines du droit</span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ secure_url('backend/theme/create') }}">Ajouter domaine</a></li>
                    </ul>
                </li>
                @if(\Auth::user()->roles->contains('id',1))
                    <li><hr></li>
                    <li class="menu-title">Administrateur</li>
                    <li>
                        <a href="javascript: void(0);"><i class="fas fa-gavel"></i><span> Décisions TF </span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ secure_url('backend/decision') }}">Dernières décisions</a></li>
                            <li><a href="{{ secure_url('backend/archive') }}">Archives</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);"><i class="fas fa-users"></i><span> Utilisateurs </span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ secure_url('backend/user') }}">Gestion</a></li>
                            <li><a href="{{ secure_url('backend/alertes') }}">Alertes</a></li>
                        </ul>
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
