<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('img/icono_phoneUp.png')}}" class="img-circle" alt="User">
            </div>
            <div class="pull-left info">
                <p>{{\Auth::user()->nombres}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i>{{trans('menus.izquierdo.enlinea')}}</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul id="menu_Pp_Izq" class="sidebar-menu" data-widget="tree">
            <li class="header text-center">{{trans('menus.izquierdo.navprincipal')}}</li>

            <!-- MI PERFIL -->
            <li class="{{$activeMiPerfil or ''}} ">
                <a href="{{route('getMiPerfil')}}">
                    <i class="fa fa-user"></i> <span>Mi perfil</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <!-- MARCADO -->
            <li class="{{$activeMarcado or ''}} ">
                <a href="{{route('getInicioMarcados')}}">
                    <i class="fa fa-book"></i> <span>{{trans('menus.izquierdo.marcado')}}</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <!-- HISTORIAL -->
            <li class="{{$activeHistorial or ''}} ">
                <a href="{{route('getEnConstruccion')}}">
                    <i class="fa fa-history"></i> <span>{{trans('menus.izquierdo.historial')}}</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
