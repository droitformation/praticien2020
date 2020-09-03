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
                <li class="menu-title">Navigation</li>
                <li>
                    <a {{ \Request::is('backend/arret/*') || \Request::is('backend/categorie') ? : '' }} href="{{ secure_url('backend/arret') }}"><i class="fas fa-file-edit"></i><span> Arrêts résumés</span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ secure_url('backend/arret/create') }}">Ajouter nouvel arrêt</a></li>
                        <li><a href="{{ secure_url('backend/categorie') }}">Domaines du droit</a></li>
                    </ul>
                </li>
                @if(\Auth::user()->roles->contains('id',1))
                    <li>
                        <a href="javascript: void(0);"><i class="fas fa-gavel"></i><span> Décisions TF </span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ secure_url('backend/decisions') }}">Année en cours</a></li>
                            <li><a href="{{ secure_url('backend/archive') }}">Archives</a></li>
                            <li><a href="{{ secure_url('backend/insert') }}">Gestion</a></li>
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
