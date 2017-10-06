<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{\Auth::user()->nombres}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul id="menu_Pp_Izq" class="sidebar-menu" data-widget="tree">
            <li class="header text-center">NAVEGACIÓN PRINCIPAL</li>
            <li class="{{$activeUsuarios or ''}} ">
                <a href="{{route('getListadoUsuarios')}}">
                    <i class="fa fa-user-circle-o"></i> <span>Usuarios</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <li class="header text-center">Gestión de conjuntos</li>
            <!-- CANALES DE COMUNICACIÓN -->
            <li class="{{$activeCC or ''}} ">
                <a href="{{route('getModuloCC')}}">
                    <i class="fa fa-commenting"></i> <span>Canales Comunicación</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <!-- CATALOGO -->
            <li class="treeview {{$activeCatalogo or ''}}">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Catalogos</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{$activeAdminCatalogo or ''}}"><a href="{{route('getModuloCatalogos')}}"><i class="fa fa-circle-o"></i> Gestionar Catalogos</a></li>
                    <li class="{{$activeAdminUbicacion or ''}}"><a href="{{route('getUbicacionCatalogo')}}"><i class="fa fa-circle-o"></i> Ubicación Catalogos</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
