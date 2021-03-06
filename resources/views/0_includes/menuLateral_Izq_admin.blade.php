<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('img/icono_phoneUp.png')}}" class="img-responsive" alt="User">
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
            {{--<li class="{{$activeHistorial or ''}} ">--}}
                {{--<a href="{{route('getEnConstruccion')}}">--}}
                    {{--<i class="fa fa-history"></i> <span>{{trans('menus.izquierdo.historial')}}</span>--}}
                    {{--<span class="pull-right-container"></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="header text-center">{{trans('menus.izquierdo.gestionconjuntos')}}</li>
            <!-- GESTION DE USUARIOS -->
            <li class="{{$activeUsuarios or ''}} ">
                <a href="{{route('getListadoUsuarios')}}">
                    <i class="fa fa-user-circle-o"></i> <span>{{trans('menus.izquierdo.usuarios')}}</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <!-- GESTION DE CONJUNTOS -->
            <li class="{{$activeConjuntos or ''}} ">
                <a href="{{route('getInicioConjuntos')}}">
                    <i class="fa fa-building-o"></i> <span>{{trans('menus.izquierdo.conjunto')}}</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <!-- GESTION EXTENSIONES -->
            <li class="{{$activeExtensiones or ''}} ">
                <a href="{{route('getInicioExtensiones')}}">
                    <i class="fa fa-phone"></i> <span>Extensiones</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <!-- NOTIFICACIONES -->
            {{--<li class="treeview {{$activeNotificaciones or ''}}">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-bell-o"></i> <span>{{trans('menus.izquierdo.notificaciones')}}</span>--}}
                    {{--<span class="pull-right-container">--}}
                      {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li class="{{$activeNotificacionesInicio or ''}}"><a href="{{route('getEnConstruccion')}}"><i class="fa fa-circle-o"></i> {{trans('menus.izquierdo.gestionsalidas')}}</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <!-- CONFIGURACIONES BASICAS -->
            <li class="bg-orange"><a href="{{route('getConfiguraciones')}}"><i class="fa fa-cog" style="color: rgb(255, 255, 255);"></i><span style="color: rgb(255, 255, 255);"> {{trans('menus.izquierdo.configbasicas')}}</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
