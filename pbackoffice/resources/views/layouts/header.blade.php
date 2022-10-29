<div id="header" class="header navbar-default">
    <!-- begin navbar-header -->
    <div class="navbar-header">
    <a href="/backoffice" class="navbar-brand"><img src="{{ asset('img/LogoFondoTransparente.png')}}" alt=""></a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <form class="navbar-nav navbar-right" action="{{ruta('cerrarSesion')}}" method="POST">
        @csrf
        <ul class="navbar-nav navbar-right">
            <li class="navbar-form">
            </li>
            <li>           
                <a onclick="$(this).closest('form').submit();" href="javascript:;" class="dropdown-toggle f-s-14">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </form>
    <!-- end header-nav -->
</div>