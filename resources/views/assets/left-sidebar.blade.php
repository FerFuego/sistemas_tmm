@if (Auth::guest())
    <!--<li>Debes iniciar sesión</li>-->
@else
<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                @if (Auth::guest())
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="text-white" href="{{ route('login') }}">Ingresar</a></li>
                        {{-- <li class="nav-item"><a class="text-white" href="{{ route('register') }}">Registrarse</a></li> --}}
                    </ul>
                @else
                    @if(File::exists('images/users/'. Auth::user()->avatar))
                        <div class="thumbnail-img center-block" style="background-image: url({{ asset('images/users/'. Auth::user()->avatar)}});background-size: cover; width: 50px; height: 50px;resize: none; border-radius:50%; overflow: hidden;">
                        </div>
                    @else
                        <div class="thumbnail-img center-block">
                            <img src="{{ asset('images/users/robot.jpg')}}">
                        </div>
                    @endif
                    <a href="#" data-toggle="modal" data-target="#avatar-modal" class="text-muted"> {{ Auth::user()->name }}</a>
                @endif
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> 
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                    </span> 
                </div>
                <!-- /input-group -->
            </li>
                @if(Auth::user()->hasRole('admin'))
                    <li class="nav-small-cap">--- MENÚ PRINCIPAL</li>
                    {{-- <li> <a href="{!! url('/admin/dashboard'); !!}" class="waves-effect"> <span class="hide-menu"> Dashboard</span></a></li> --}}
                    <li> <a href="javascript:void(0);" class="waves-effect"><span class="hide-menu"> Usuarios <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="{!! url('/usuarios/todos'); !!}">Todos los usuarios</a> </li>
                            <li> <a href="{!! url('/usuarios/nuevo'); !!}">Nuevo usuario</a> </li>
                        </ul>
                    </li>
                    <li> 
                        <a href="javascript:void(0);" class="waves-effect"><span class="hide-menu"> Rangos <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="{!! url('/rangos/pat'); !!}">Puesta a tierra</a> </li>
                            <li> <a href="{!! url('/rangos/continuidad'); !!}">Continuidad</a> </li>
                            <li> <a href="{!! url('/rangos/diferencial'); !!}">Diferencial</a> </li>
                            <li> <a href="{!! url('/rangos/termografia'); !!}">Termografía</a> </li>
                            <!-- <li role="separator" class="divider"></li> -->
                        </ul>
                    </li>
                    <li> <a href="{!! url('/pagos'); !!}" class="waves-effect"> <span class="hide-menu"> Pagos</span></a></li>
                    <li> <a href="{!! url('/banners'); !!}" class="waves-effect"> <span class="hide-menu"> Banners</span></a></li>
                    <li class="nav-small-cap">--- CONFIGURACIÓN</li>
                    <li> <a href="{!! url('usuarios/'.Auth::id().'/edit') !!}" class="waves-effect"><span class="hide-menu">Config. de Usuario</span></a> </li>
                @else
                    <!-- user link --> 
                    <li class="nav-small-cap">--- MENÚ PRINCIPAL</li>
                    <li> <a href="{!! url('/users/dashboard'); !!}" class="waves-effect"> <span class="hide-menu"> Home</span></a></li>
                    <li> <a href="javascript:void(0);" class="waves-effect"><span class="hide-menu"> Puesta a tierra <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            @if ($sucursales != '[]')
                                <li><a href="{!! url('/pat/sucursales'); !!}">Todas las sucursales</a></li>
                                @foreach($sucursales as $s)
                                    <li><a href="{!! url('/pat/sucursal/'.$s->id.'/listado'); !!}">{{ $s->name }}</a></li>
                                @endforeach
                            @else
                                <li class="text-center">No existen sucursales</li>
                            @endif
                        </ul>
                    </li>
                    <li> <a href="javascript:void(0);" class="waves-effect"><span class="hide-menu"> Continuidad <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            @if ($sucursales != '[]')
                                <li><a href="{!! url('/continuidad/sucursales'); !!}">Todas las sucursales</a></li>
                                @foreach($sucursales as $s)
                                    <li><a href="{!! url('/continuidad/sucursal/'.$s->id.'/listado'); !!}">{{ $s->name }}</a></li>
                                @endforeach
                            @else
                                <li class="text-center">No existen sucursales</li>
                            @endif
                        </ul>
                    </li>
                    <li> <a href="javascript:void(0);" class="waves-effect"><span class="hide-menu"> Diferenciales <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            @if ($sucursales != '[]')
                                <li><a href="{!! url('/diferencial/sucursales'); !!}">Todas las sucursales</a></li>
                                 @foreach($sucursales as $s)
                                    <li><a href="{!! url('/diferencial/sucursal/'.$s->id.'/listado'); !!}">{{ $s->name }}</a></li>
                                @endforeach
                            @else
                                <li class="text-center">No existen sucursales</li>
                            @endif
                        </ul>
                    </li>
                    <li> <a href="javascript:void(0);" class="waves-effect"><span class="hide-menu"> Termografía <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            @if ($sucursales != '[]')
                                <li><a href="{!! url('/termografia/sucursales'); !!}">Todas las sucursales</a></li>
                                 @foreach($sucursales as $s)
                                    <li><a href="{!! url('/termografia/sucursal/'.$s->id.'/listado'); !!}">{{ $s->name }}</a></li>
                                @endforeach
                            @else
                                <li class="text-center">No existen sucursales</li>
                            @endif
                        </ul>
                    </li>
                    <li> <a href="{!! url('mediciones-srt/show'); !!}" class="waves-effect"> <span class="hide-menu"> Medición SRT</span></a></li>
                @endif
                <li>
                     <a href="{{ route('logout') }}" class="waves-effect" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-logout fa-fw"></i> <span class="hide-menu">Salir</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>   
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->
@endif

<!-- Modal Create-->
<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avatarModalLabel">IMAGEN DE PERFIL
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h5>
      </div>
      <div class="modal-body">
        {{ Form::open(['url'=>'user/updateAvatar', 'method'=>'post', 'class'=>'form row','enctype'=>'multipart/form-data']) }}
            {{ Form::hidden('idusers', $user->id) }}
            <div class="col-sm-12">
              <div class="form-group">
                {{ Form::label('Cambiar Avatar') }}
                {{ Form::file('avatar', ['class'=>'form-control','required']) }}
              </div>
            </div>
            <div class="col-sm-12 text-right">
              <hr>
              <div class="form-group">
                {{ Form::reset('Descartar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-muted',' data-dismiss'=>'modal']) }}
                {{ Form::submit('Cambiar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
              </div>
            </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>