@extends('layouts.app')

@section('title-section','MEDICIÓN DE DIFERENCIALES')

@section('breadcrumbs')
    @if(Auth::user()->hasRole('user'))
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="capitalize"><a href="{{ url('/'.$type.'/sucursales') }}">Diferenciales / Sucursales</a></li>
        <li><a href="{{ url($type.'/sucursal/'.$medida->idbranch_office.'/listado') }}">{{ $medida->place }}</a></li>
        <li><a href="{{ url('sucursal/'.$medida->idbranch_office.'/'.$type.'/'.$medida->id) }}">Detalle</a></li>
        <li class="active">{{ $value->details }}</li>
      </ol>
    @elseif(Auth::user()->hasRole('admin'))
      <ol class="breadcrumb">
        <li><a href="{{ url('usuarios/todos') }}">usuarios</a></li>
        <li><a href="{{ url('usuarios/'.$user->id.'/ver') }}">{{ $user->name}}</a></li>
        <li><a href="{{ url('usuario/'.$user->id.'/sucursal/'.$sucursal->id.'/'.$type.'/'.$medida->id) }}">{{ $sucursal->name }}</a></li>
        <li class="active">{{ $value->details }}</li>
      </ol>
    @endif
@endsection

@section('content')
    @php
        $range='FUERA';
    @endphp
    <div class="row info-basica">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
          <div class="white-box height-100">
            <table class="table text-left table-bordered table-striped">
               <tr>
                    <td><b>Fecha:</b></td>
                    <td class="b-l-none">{{ date_format(date_create($medida->date), 'd-m-Y') }}</td>
                    <td><b>Reglamentacion:</b></td>
                    <td class="b-l-none">{{ $medida->regulation }}</td>
               </tr>
                <tr>
                    <td><b>Establecimiento y Sucursal:</b></td>
                    <td class="b-l-none text-uppercase">{{ $user->name }} / {{ $medida->place }}</td>
                    <td><b>Instrumento:</b></td>
                    <td class="b-l-none">{{ $medida->instrument }}</td>
               </tr>
            </table>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <div class="white-box height-100 text-center" style="display:table;">
                <div style="display: table-cell; vertical-align: middle;">
                    @if($criticidad)
                        <img src="{{ asset('images/'.$criticidad['rango'].'.svg') }}" width="100%">
                        Criticidad: {{ $criticidad['criticidad'] }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="white-box">
                       @if($value->image_1)
                            <a href="{{ asset('images/catalog/'.$value->image_1) }}" data-lightbox="image-1" data-title="Imagen Diferencial"><img src="{{ asset('images/catalog/'.$value->image_1) }}" class="img-responsive"></a>
                        @else
                            <img src="{{ asset('images/nophoto.svg') }}" class="img-responsive">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="white-box">
                {{-- <h3 class="text-uppercase">Detalle: {{ $value->details }}</h3> --}}
                <table class="table table-bordered table-striped  align-bottom">
                    <tr>
                        <td class="width-min-tmm b-r-none"><b>Detalle:</b></td>
                        <td class="width-med-tmm b-r-none">{{ $value->details }}</td>
                        <td class="width-min-tmm b-l-none"></td>
                        <td class="width-min-tmm b-r-none"><b>Sector:</b></td>
                        <td class="width-med-tmm">{{ $value->sector }}</td>
                    </tr>
                </table>
                <table class="table table-bordered table-striped text-center">
                    <tbody>
                        <tr>
                            <td><b>Diferencial Nro</b></td>
                            <td class="text-center"><b>Valor ms</b></td>
                            <td class="text-left"><b>Observaciones particulares</b></td>
                        </tr>
                        @foreach (json_decode($value->value, true) as $key => $desc)
                            <tr>
                                <td class="width-mas-tmm">Punto {{ $key + 1 }}</td>
                                <td class="width-mas-tmm">
                                    @if($desc[2] == 'RANGO_1') 
                                    <div class="mini-table-med-show">
                                        <div class="col-mini-1">
                                            @if(isset($desc[3]) && !is_null($desc[3])) 
                                                {{ $desc[3] }} 
                                            @else 
                                                {{ (int) $desc[0] }} ms 
                                            @endif</div>
                                        <div class="col-mini-2"><i class="icon-check text-success" title="valor normal" style="top:-10px!important; right:-10px;"></i> </div>
                                    </div>
                                    @elseif($desc[2] == 'RANGO_2') 
                                    <div class="mini-table-med-show">
                                        <div class="col-mini-1">
                                            @if(isset($desc[3]) && !is_null($desc[3])) 
                                                {{ $desc[3] }} 
                                            @else 
                                                {{ (int) $desc[0] }} ms
                                            @endif </div>
                                        <div class="col-mini-2"><i class="icon-info text-warning" title="valor incipiente" style="top:-10px!important; right:-10px;"></i> </div>
                                    </div>
                                    @elseif($desc[2] == 'RANGO_3') 
                                    <div class="mini-table-med-show">
                                        <div class="col-mini-1">
                                            @if(isset($desc[3]) && !is_null($desc[3])) 
                                                {{ $desc[3] }} 
                                            @else 
                                                {{ (int) $desc[0] }} ms
                                            @endif </div>
                                        <div class="col-mini-2"><i class="icon-close text-danger" title="valor severo" style="top:-10px!important; right:-10px;"></i> </div>
                                    </div>
                                    @else 
                                    <div class="mini-table-med-show">
                                        <div class="col-mini-1">
                                            @if(isset($desc[3]) && !is_null($desc[3])) 
                                                {{ $desc[3] }} 
                                            @else 
                                                {{ (int) $desc[0] }} ms
                                            @endif </div>
                                        <div class="col-mini-2"><i class="icon-close text-danger" title="valor severo" style="top:-10px!important; right:-10px;"></i></div>
                                    </div>
                                    @endif
                                </td>
                                <td class="text-left">{{ $desc[1] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(Auth::user()->hasRole('admin'))
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <a href="{!! url('exportMedition/'.$medida->type.'/'.$value->id); !!}">
                    <button class="btn btn btn-default btn-custom-tmm btn-custom-tmm-active">Exportar análisis</button>
                </a>
            </div>
        </div>
    @endif
    <hr>

    <div class="row">
        <div class="col-md-12 col-lg-6 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">REPORTES
                    <a href=""  data-toggle="modal" data-target="#Modal_reports" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-active pull-right">Generar Reporte</a>
                </h3>
                <div class="border-muted-tmm border-muted-tmm-hover">
                    <i class="fa fa-list" aria-hidden="true"></i>
                </div>
                <div class="table-responsive b-t-show">
                    <table class="table text-center table-border-none">
                        @if($reporte!='[]')
                            <tr>
                                <td><b>Importancia</b></td>
                                <td><b>Fecha</b></td>
                                <td><b>Título</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach($reporte as $r)
                                <tr>
                                    <td>{{ $r->importance }}</td>
                                    <td>{{ date_format(date_create($r->date), 'd-m-Y') }}</td>
                                    <td>{{ $r->title }}</td>
                                    <td><a href="javascript:void(0);" onClick="reportEdit({{ $r }})" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a></td>
                                    <td><a href="{!! route('reporte.delete', [$r->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <br><p>No hay reportes de éste análisis.</p>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">ALARMAS
                    <a href=""  data-toggle="modal" data-target="#Modal_alarms" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-active pull-right">Generar Alarma</a>
                </h3>
                <div class="border-muted-tmm border-muted-tmm-hover">
                    <i class="fa fa-bell-o" aria-hidden="true"></i>
                </div>
                 <div class="table-responsive b-t-show">
                    <table class="table text-center table-border-none">
                         @if($alarmas!='[]')
                            <tr>
                                <td><b>Fecha</b></td>
                                <td><b>Título</b></td>
                                <td><b>Usuario</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach($alarmas as $r)
                                <tr>
                                    <td>{{ date_format(date_create($r->date), 'd-m-Y') }}</td>
                                    <td>{{ $r->title }}</td>
                                    <td>{{ $r->name }}</td>
                                    <td><a href="javascript:void(0);" onClick="alarmaEdit({{ $r }})" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a></td>
                                    <td><a href="{!! route('alarma.delete', [$r->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <br><p>No hay alarmas de éste análisis.</p>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reports -->
    <div class="modal fade" id="Modal_reports" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO REPORTE
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </h5>
          </div>
           <form method="POST" action="{{ url('/reporte/store') }}" id="FormReport">
              <div class="modal-body">
                {{ csrf_field() }}
                {{ Form::hidden('idvalues', $value->id) }}
                {{ Form::hidden('date', \Carbon\Carbon::now()) }}
                <div class="form-group">
                    {{ Form::label('Título') }}
                    {{ Form::text('title', null, ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Importancia') }}
                    <select name="importance" class="form-control">
                        <option value="Normal">Normal</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="form-group">
                    {{ Form::label('Detalle') }}
                    {{ Form::textarea('detail', null, ['class'=>'form-control']) }}
                </div>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-muted" data-dismiss="modal">Descartar</button>
            {{ Form::submit('Crear Reporte', ['class'=>'btn btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
          </div>
        {{ Form::close() }}
        </div>
      </div>
    </div>

    <!-- Modal Alarms-->
    <div class="modal fade" id="Modal_alarms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVA ALARMA
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </h5>
          </div>
           <form method="POST" action="{{ url('/alarma/store') }}" id="FormAlarm">
              <div class="modal-body">
                {{ csrf_field() }}
                {{ Form::hidden('idvalues', $value->id) }}
                {{ Form::hidden('date', \Carbon\Carbon::now()) }}
                {{ Form::hidden('type', 'diferencial') }}
                <div class="row form-group">
                    <div class="col-md-6">
                        {{ Form::label('Fecha de la alarma') }}
                        {{ Form::date('date', null, ['class'=>'form-control'])}}
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('Hora de la alarma') }}
                        {{ Form::time('datetime', null, ['class'=>'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Título') }}
                    {{ Form::text('title', null, ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Detalle') }}
                    {{ Form::textarea('detail', null, ['class'=>'form-control','rows'=>'4']) }}
                </div>
                <hr>
                <table id="tblprod" class="table table-border-none">
                    <tr>
                        <td><label>Nombre</label></td>
                        <td><input type="text" name="name[]" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="text" name="email[]" class="form-control"></td>
                    </tr>
                </table>
                <a href="javascript:{};" id="btnadd" class="text-info"><i class="fa fa-plus-circle"></i> AGREGAR USUARIO</a>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-muted" data-dismiss="modal">Descartar</button>
            {{ Form::submit('Crear Alarma', ['class'=>'btn btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
          </div>
        {{ Form::close() }}
        </div>
      </div>
    </div>

    <!-- Modal Edit Alarms-->
    <div class="modal fade" id="Modal_edit_alarms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">EDITAR ALARMA
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </h5>
          </div>
           <form method="POST" action="{{ url('alarma/update') }}" id="FormAlarm">
              <div class="modal-body">
                {{ csrf_field() }}
                {{ Form::hidden('id', null, ['id'=>'id_update']) }}
                {{ Form::hidden('idvalues', null, ['id'=>'id_value_update']) }}
                {{ Form::hidden('type', 'pat') }}
                <div class="row form-group">
                    <div class="col-md-6">
                        {{ Form::label('Fecha de la alarma') }}
                        {{ Form::date('date', null, ['class'=>'form-control', 'id'=>'date_update'])}}
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('Hora de la alarma') }}
                        {{ Form::time('datetime', null, ['class'=>'form-control', 'id'=>'datetime_update'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('Título') }}
                    {{ Form::text('title', null, ['class'=>'form-control', 'id'=>'title_update']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Detalle') }}
                    {{ Form::textarea('detail', null, ['class'=>'form-control','rows'=>'4', 'id'=>'detail_update']) }}
                </div>
                <hr>
                <table id="tblprod_2" class="table table-border-none">
                    <tr>
                        <td><label>Nombre</label></td>
                        <td><input type="text" name="name[]" class="form-control" id="name_update"></td>
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="text" name="email[]" class="form-control" id="email_update"></td>
                    </tr>
                </table>
                <a href="javascript:{};" id="btnadd_2" class="text-info"><i class="fa fa-plus-circle"></i> AGREGAR USUARIO</a>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-muted" data-dismiss="modal">Descartar</button>
            {{ Form::submit('Guardar', ['class'=>'btn btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
          </div>
        {{ Form::close() }}
        </div>
      </div>
    </div>

    <!-- Modal Edit Reports -->
    <div class="modal fade" id="Modal_edit_reports" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">EDITAR REPORTE
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </h5>
          </div>
           <form method="POST" action="{{ url('/reporte/update') }}" id="FormReport">
              <div class="modal-body">
                {{ csrf_field() }}
                {{ Form::hidden('id', null, ['id'=>'id_r_update']) }}
                {{ Form::hidden('idvalues', null, ['id'=>'id_r_value_update']) }}
                {{ Form::hidden('date', \Carbon\Carbon::now()) }}
                <div class="form-group">
                    {{ Form::label('Título') }}
                    {{ Form::text('title', null, ['class'=>'form-control','id'=>'title_r_update']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Importancia') }}
                    <select name="importance" class="form-control" id="importance_update">
                        <option value="Normal">Normal</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="form-group">
                    {{ Form::label('Detalle') }}
                    {{ Form::textarea('detail', null, ['class'=>'form-control', 'id'=>'detail_r_update']) }}
                </div>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-muted" data-dismiss="modal">Descartar</button>
            {{ Form::submit('Guardar', ['class'=>'btn btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
          </div>
        {{ Form::close() }}
        </div>
      </div>
    </div>

@endsection 

@section('javascript')
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
  <script type="text/javascript">
    $(function() {
        var count = 1;
        $(document).on("click","#btnadd",function( event ) {  
            var tr=document.getElementById("tblprod").rows.length;
            count++; 
            $('#tblprod tr:last').after('<tr><td><label>Nombre</label></td><td><input type="text" name="name[]" class="form-control"></td></tr><tr><td><label>Email</label></td><td><input type="text" name="email[]" class="form-control"></td></tr>');
            event.preventDefault();
            tr = document.getElementById("tblprod").rows.length;
        });
        $(document).on("click","#btnadd_2",function( event ) {  
            var tr=document.getElementById("tblprod_2").rows.length;
            count++; 
            $('#tblprod_2 tr:last').after('<tr><td><label>Nombre</label></td><td><input type="text" name="name[]" class="form-control"></td></tr><tr><td><label>Email</label></td><td><input type="text" name="email[]" class="form-control"></td></tr>');
            event.preventDefault();
            tr = document.getElementById("tblprod_2").rows.length;
        });
    });

    function alarmaEdit(data){
      var date = data.date;
      var fecha = date.split(" ");
      $('#id_update').val(data.id);
      $('#id_value_update').val(data.idvalues);
      $('#title_update').val(data.title);
      $('#date_update').val(fecha[0]);
      $('#datetime_update').val(fecha[1]);
      $('#detail_update').val(data.detail);
      $('#name_update').val(data.name);
      $('#email_update').val(data.email);

      $("#Modal_edit_alarms").modal();
    }

    function reportEdit(data){
      var date = data.date;
      var fecha = date.split(" ");
      $('#id_r_update').val(data.id);
      $('#id_r_value_update').val(data.idvalues);
      $('#title_r_update').val(data.title);
      $('#importance_update').val(data.importance);
      $('#detail_r_update').val(data.detail);

      $("#Modal_edit_reports").modal();
    }
  </script>
@stop