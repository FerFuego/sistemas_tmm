@extends('layouts.app')

@section('title-section','USUARIO')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li><a href="{{ url('usuarios/todos') }}">usuarios</a></li>
    <li class="active">{{ $user->name}}</li>
  </ol>
@endsection

@section('content')
	<h1 class="text-center text-uppercase">{{ $user->name }}</h1>

    <div class="white-box">
        <h3 class="box-title m-b-0">GENERAR NUEVA MEDICIÓN  PUESTA A TIERRA / CONTINUIDAD / DIFERENCIALES / TERMOGRAFÍA 
            <div class="pull-right">
                <button type="button" class="btn btn-default btn-custom-tmm btn-custom-tmm-active" data-toggle="modal" data-target="#Modal_medicion">Nueva medición</button>
            </div>
        </h3>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12">
          <div class="white-box">
              <div class="row porcentaje row-in">
                @if($branchoffs)
                  @foreach ($branchoffs as $branchoff)
                    @if($criticidadGral)
                      @foreach($criticidadGral as $c)
                        @if($c['branch'] == $branchoff->id)
                            <div class="col-lg-3 col-sm-6 row-in-br branch-container">
                                <div class="delete-branch">
                                  <a href="{{ route('branchoffice.destroy', $branchoff->id) }}" onclick="return confirm('Si elimina la Sucursal, tambien se perderán todas las mediciones correspondientes.\r\n¿Seguro deseas eliminar la sucursal?');" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
                                </div>
                                <div class="col-in row">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <a href="{!! route('usuarios.sucursal', [$user->id, $branchoff->id]); !!}">
                                          <br><i class="icon-pie-chart text-muted"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <a href="{!! route('usuarios.sucursal', [$user->id, $branchoff->id]); !!}">
                                          <h3 class="counter text-right m-t-15 text-{{ $c['class'] }}">
                                            {{ $totalSucursal = number_format($c['criticidad']) }} %
                                          </h3>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <a href="{!! route('usuarios.sucursal', [$user->id, $branchoff->id]); !!}">
                                          <h5 class="text-muted vb">CRITICIDAD {{ $branchoff->name }}</h5>
                                        </a>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-{{ $c['class'] }} wow animated progress-animated"
                                            role="progressbar"
                                            aria-valuenow="{{ $totalSucursal }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            style="width: {{ $totalSucursal }}%">
                                            <span class="sr-only">{{ $totalSucursal }}% Complete (success)</span>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                      @endforeach
                    @endif
                  @endforeach
                @endif
                  <div class="col-lg-2 col-sm-6  b-0">
                      <div class="col-in row">
                        <div class="col-md-12 rounded-box-tmm text-center">
                          <a href="" data-toggle="modal" data-target="#Modal_sucursal" class="text-merge nounderline">
                                <div class="text-center">
                                    <span class="icon-plus fa-3x" aria-hidden="true"></span>
                                </div>
                                Agregar<br> sucursales
                            </a>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  @if($mediciones)
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
          <div class="white-box">
            <h3 class="box-title m-b-0">ÚLTIMAS MEDICIONES</h3>
            <br>
            <table class="table pat-table table-bordered text-center">
              <thead>
                <tr>
                  <th class="text-center">Medición</th>
                  <th class="text-center">Sucursal</th>
                  <th class="text-center">Fecha de medición</th>
                  <th class="text-center">Nivel de criticidad general  de la última medición</th>
                  <th class="text-center">Vigencia medición</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($mediciones as $med)
                  <tr>
                    <td class="text-capitalize">
                      @if($med->type == 'diferencial')
                        Diferenciales
                      @else
                        {{ $med->type }}
                      @endif
                    </td>
                    <td>{{ $med->name }}</td>
                    <td>{{ date_format(date_create($med->date), 'd-m-Y') }}</td>
                    <td>
                      @if($med->type == 'pat')
                        @if($puestatierra != [])
                          @foreach($puestatierra as $pt)
                            @if($pt['id'] == $med->id)
                                  <span>{{ number_format($pt['criterion'], 2) }}%</span>
                                  <div class="progress">
                                      <div class="progress-bar progress-bar-{{ $pt['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $pt['criterion'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $pt['criterion'] }}%;"></div>
                                  </div>
                            @endif
                          @endforeach
                        @endif
                      @endif
                      @if($med->type == 'continuidad')
                        @foreach($continuidad as $cyd)
                          @if($cyd['id'] == $med->id)
                                <span>{{ number_format($cyd['criticidad'], 2) }}%</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-{{ $cyd['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $cyd['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $cyd['criticidad'] }}%;"></div>
                                </div>
                            @endif
                          @endforeach
                      @endif

                      @if($med->type == 'diferencial')
                        @foreach($diferencial as $cyd)
                            @if($cyd['id'] == $med->id)
                                <span>{{ number_format($cyd['criticidad'], 2) }}%</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-{{ $cyd['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $cyd['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $cyd['criticidad'] }}%;"></div>
                                </div>
                            @endif
                          @endforeach
                      @endif
                      @if($med->type == 'termografia')
                        @if ($termografia != [])
                          @foreach($termografia as $t)
                            @if($t['id'] == $med->id)
                                <span>{{ number_format($t['criterion'], 2) }}%</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-{{ $t['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $t['criterion'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $t['criterion'] }}%;"></div>
                                </div>
                            @endif
                          @endforeach
                        @endif
                      @endif
                    </td>
                    <td>
                        @php
                          $datetime1 = new DateTime($med->date);
                          $datetime2 = \Carbon\Carbon::now();
                          $interval = $datetime1->diff($datetime2);
                          $intval = $interval->format('%a');
                        @endphp
                       
                        @if($med->type == 'pat')
                            @if($intval<=334)
                              @php $vigencia = 'Vigente'; @endphp
                              @php $class = 'text-success'; @endphp
                            @elseif($intval > 334 && $intval < 365)
                              @php $vigencia = 'En fecha de renovación'; @endphp
                              @php $class = 'text-warning'; @endphp
                            @elseif($intval > 365)
                              @php $vigencia = 'Medicion no vigente';@endphp
                              @php $class = 'text-danger'; @endphp
                            @endif
                        @elseif($med->type == 'continuidad')
                            @if($intval<=334)
                              @php $vigencia = 'Vigente'; @endphp
                              @php $class = 'text-success'; @endphp
                            @elseif($intval > 334 && $intval < 365)
                              @php $vigencia = 'En fecha de renovación'; @endphp
                              @php $class = 'text-warning'; @endphp
                            @elseif($intval > 365)
                              @php $vigencia = 'Medicion no vigente';@endphp
                              @php $class = 'text-danger'; @endphp
                            @endif
                        @elseif($med->type == 'diferencial')
                            @if($intval<=334)
                              @php $vigencia = 'Vigente'; @endphp
                              @php $class = 'text-success'; @endphp
                            @elseif($intval > 334 && $intval < 365)
                              @php $vigencia = 'En fecha de renovación'; @endphp
                              @php $class = 'text-warning'; @endphp
                            @elseif($intval > 365)
                              @php $vigencia = 'Medicion no vigente';@endphp
                              @php $class = 'text-danger'; @endphp
                            @endif
                        @elseif($med->type == 'termografia')
                          @if($intval<=152)
                            @php $vigencia = 'Vigente'; @endphp
                            @php $class = 'text-success'; @endphp
                          @elseif($intval > 152 && $intval < 182)
                            @php $vigencia = 'En fecha de renovación'; @endphp
                            @php $class = 'text-warning'; @endphp
                          @elseif($intval > 182)
                            @php $vigencia = 'Medicion no vigente';@endphp
                            @php $class = 'text-danger'; @endphp
                          @endif
                        @else
                            @php $vigencia = '';@endphp
                            @php $class = ''; @endphp
                        @endif
                      <div class="{{ $class }}">{{ $vigencia }}</div>
                    </td>
                    <td>
                      <a href="{!! route('usuario.sucursal.show', [$user->id, $med->idbranch_office, $med->type, $med->id]) !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
                      <a href="{!! route('measurement/duplicate', [$med->id]) !!}" class="fa-link-tmm text-info"><i class="fa fa-copy"></i></a>
                      <a href="{!! route('usuarios.sucursal.edit', [$user->id, $med->idbranch_office, $med->type, $med->id]); !!}" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a>
                      <a href="{!! route('measurement.delete', [$med->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
  @endif

    <div class="row">
      <div class="col-sm-3 box-tmm box-blue text-center">
         <h3>
          @php
            $cx = 0;
          @endphp
          @if($contador)
            @foreach($contador as $contado)
              @if($contado->type =='pat')
                @php
                  $cx = $contado->num;
                @endphp
                  <span>{{ $cx }}</span>
              @endif
            @endforeach
          @endif
          Puestas a Tierra
        </h3>
        @if ($cx > 0)
          <a href="{!! route('usuario.tipo.listado', [$user->id, 'pat']); !!}" title="" class="text-white">ver todas</a>
        @endif
      </div>
      <div class="col-sm-3 box-tmm box-muted text-center">
        <h3>
          @php
            $cx = 0;
          @endphp
          @if($contador)
            @foreach($contador as $contado)
              @if($contado->type =='continuidad')
                  @php
                    $cx = $contado->num;
                  @endphp
                  <span>{{ $cx }}</span>
              @endif
            @endforeach
          @endif
          Continuidad
        </h3>
        @if ($cx > 0)
          <a href="{!! route('usuario.tipo.listado', [$user->id, 'continuidad']); !!}" title="" class="text-white">ver todas</a>
        @endif
      </div>
	    <div class="col-sm-3 box-tmm text-center">
       <h3>
          @php
            $cx = 0;
          @endphp
          @if($contador)
            @foreach($contador as $contado)
              @if($contado->type =='diferencial')
                  @php
                    $cx = $contado->num;
                  @endphp
                  <span>{{ $cx }}</span>
              @endif
            @endforeach
          @endif
          Diferenciales
        </h3>
        @if ($cx > 0)
          <a href="{!! route('usuario.tipo.listado', [$user->id, 'diferencial']); !!}" title="" class="text-merge">ver todas</a>
        @endif
	    </div>
      <div class="col-sm-3 box-tmm box-merge text-center">
        <h3>
          @php
            $cx = 0;
          @endphp
          @if($contador)
            @foreach($contador as $contado)
              @if($contado->type =='termografia')
              @php
                $cx = $contado->num;
              @endphp
                  <span>{{ $cx }}</span>
              @endif
            @endforeach
          @endif
          Termografías
        </h3>
        @if ($cx > 0)
          <a href="{!! route('usuario.tipo.listado', [$user->id, 'termografia']); !!}" title="" class="text-white">ver todas</a>
        @endif
      </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-6 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">MEDICIONES VIGENTES</h3>
                <div class="border-muted-tmm">
                	<i class="fa fa-bell-o" aria-hidden="true"></i>
                </div>
                <div class="table-responsive">
                  @if($mediciones && $mediciones != '')
                      <table class="table text-center table-border-none">
                          <thead>
                              <tr>
                                  <th class="text-center">Sucursal</th>
                                  <th class="text-center">Fecha de medición</th>
                                  <th class="text-center">Analisis realizado</th>
                                  <th class="text-center">Descargar certificado</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($mediciones as $m)
                                  <tr>
                                      <td class="txt-oflo">{{ $m->place }}</td>
                                      <td>{{ date_format(date_create($m->date), 'd-m-Y') }}</td>
                                      <td class="txt-oflo text-capitalize">
                                        @if($m->type == 'diferencial')
                                            Diferenciales
                                        @else
                                            {{ $m->type }}
                                        @endif
                                      </td>
                                      <td>
                                          @if(!empty($m->archivo_3))
                                            <a href="{{asset('files/certificates/'.$m->archivo_3)}}" target="_blank" title="Imagen de crokis de planta"><i class="icon-cloud-upload icon-resp"></i></a>
                                          @endif
                                          @if(!empty($m->archivo_2))
                                            <a href="{{asset('files/certificates/'.$m->archivo_2)}}" target="_blank" title="Certificado de Calibración"><i class="icon-cloud-upload icon-resp"></i></a>
                                          @endif
                                          @if(!empty($m->archivo_1))
                                            <a href="{{asset('files/certificates/'.$m->archivo_1)}}" target="_blank" title="Protocolo SRT 900/2015"><i class="icon-cloud-upload icon-resp"></i></a>
                                          @endif
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  @else
                    <hr><h5>No hay certificados de mediciones</h5>
                  @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">
                	INFO BÁSICA DEL USUARIO
	                <div class="pull-right">
	                	<ul class="list-inline">
                      <li class="list-inline-item">
                        <a href="{{ route('usuarios.editar', $user->id) }}" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a>
                      </li>
	                		<li class="list-inline-item">
                        <a href="{{ route('usuarios.lock', $user->id) }}" onclick="return confirm('¿Seguro deseas bloquear al usuario?');" class="fa-link-tmm text-warning"><i class="icon-ban"></i></a>
                      </li>
                      <li class="list-inline-item">
	                		<a href="{{ route('usuarios.destroy', $user->id) }}" onclick="return confirm('¿Seguro deseas eliminar el usuario?');" class="fa-link-tmm text-danger"><i class="icon-trash" style="font-size:20px;"></i></a>
                      </li>
                  	</ul>
	                </div>
                </h3>
                <hr>
                <table class="table table-responsive table-border-none">
                	<tbody>
                		<tr>
                			<td><b>Dirección</b></td>
                			<td>{{ $user->address }}</td>
                		</tr>
                		<tr>
                			<td><b>Email</b></td>
                			<td>{{ $user->email }}</td>
                		</tr>
                		<tr>
                			<td><b>Teléfono</b></td>
                			<td>{{ $user->phone }}</td>
                		</tr>
                	</tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal_medicion -->
    <div class="modal fade" id="Modal_medicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">NUEVA MEDICIÓN
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </h5>
            </div>
            <div class="modal-body">
              {{ Form::open(['url'=>'usuarios/sucursal/Medida/nuevo', 'method'=>'post', 'class'=>'form row']) }}
                {{ Form::hidden('idu', $user->id) }}
                <div class="col-sm-12">
                  <div class="form-group">
                    {{ Form::label('Sucursal') }}
                    <select name="sucursal" id="sucursal" class="form-control" required>
                       @foreach ($branchoffs as $branchoff)
                         <option value="{{ $branchoff->id }}">{{ $branchoff->name }}</option>
                       @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    {{ Form::label('Tipo de medición') }}
                    {{ Form::select('type', ['pat' => 'PAT', 'continuidad' => 'CONTINUIDAD', 'diferencial' => 'DIFERENCIAL', 'termografia' => 'TERMOGRAFÍA'], null, ['class' => 'form-control', 'required'=>'required']) }}
                  </div>
                </div>
                <div class="col-sm-12 text-right">
                  <hr>
                  <div class="form-group">
                    {{ Form::reset('Descartar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-muted',' data-dismiss'=>'modal']) }}
                    {{ Form::submit('Crear medición', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
                  </div>
                </div>
              {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Modal_medicion -->

    <!-- Modal_sucursal -->
    <div class="modal fade" id="Modal_sucursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVA SUCURSAL
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </h5>
          </div>
          <div class="modal-body">
            {{ Form::open(['url'=>'branchoffice/create_show', 'method'=>'post', 'class'=>'form row']) }}
                {{ Form::hidden('idusers', $user->id) }}
                <div class="col-sm-12">
                  <div class="form-group">
                    {{ Form::label('Nombre') }}
                    {{ Form::text('name', null, ['class'=>'form-control','required'=>'required']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Dirección') }}
                    {{ Form::text('address', null, ['class'=>'form-control']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Teléfono') }}
                    {{ Form::text('phone', null, ['class'=>'form-control']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Email') }}
                    {{ Form::email('email', null, ['class'=>'form-control']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Localidad') }}
                    {{ Form::text('location', null, ['class'=>'form-control']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Provincia') }}
                    {{ Form::text('province', null, ['class'=>'form-control']) }}
                  </div>
                 {{--  <div class="form-group">
                    {{ Form::label('Mediciones') }}<br>
                    {{ Form::checkbox('pat', 'pat') }}
                    {{ Form::label('PAT') }}
                    {{ Form::checkbox('continuity', 'continuidad') }}
                    {{ Form::label('Continuidad') }}
                    {{ Form::checkbox('differentials', 'diferencial') }}
                    {{ Form::label('Diferenciales') }}
                    {{ Form::checkbox('thermography', 'termografia') }}
                    {{ Form::label('Termografía') }}
                  </div> --}}
                </div>
                <div class="col-sm-12 text-right">
                  <hr>
                  <div class="form-group">
                    {{ Form::reset('Descartar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-muted',' data-dismiss'=>'modal']) }}
                    {{ Form::submit('Crear sucursal', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
                  </div>
                </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Modal_sucursal -->
@endsection
