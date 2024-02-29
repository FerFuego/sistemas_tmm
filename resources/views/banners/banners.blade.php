@extends('layouts.app')

@section('title-section','BANNERS')

@section('breadcrumbs')
	<ol class="breadcrumb">
	    <li class="active">Banners</li>
	</ol>
@endsection


@section('content')
	<div class="col-md-12 col-lg-6 col-sm-12">
        <div class="white-box">
            <h3 class="box-title">LISTADO DE BANNERS
                <a href=""  data-toggle="modal" data-target="#Modal_banners" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-active pull-right">Crear Banner</a>
            </h3>
            <div class="border-muted-tmm border-muted-tmm-hover">
            	<i class="icon-pin" aria-hidden="true"></i>
            </div>
            <div class="table-responsive b-t-show">
                <table class="table text-center table-border-none">
                    @if($banners !='[]')
                        <tr>
                            <td><b>Fecha</b></td>
                            <td><b>Usuario</b></td>
                            <td><b>Imagen</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($banners as $b)
                            <tr>
                                <td>{{ date_format(date_create($b->date), 'd-m-Y') }}</td>
                                <td>
                                	@foreach ($usuarios as $u)
                                		@if ($u->id == $b->idusers)
                                			{{ $u->name}}
                                		@endif
                                	@endforeach
                                </td>
                                <td><img src="{{ asset('images/catalog/'.$b->imagen) }}" width="100px"></td>
                                <td><a href="javascript:void(0);" onClick="bannersEdit({{ $b }})" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a></td>
                                <td><a href="{!! route('/banners/delete', [$b->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a></td>
                            </tr>
                        @endforeach
                    @else
                        <br><p>No existen banners.</p>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Banners -->
    <div class="modal fade" id="Modal_banners" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO BANNER
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </h5>
          </div>
           	<form method="POST" action="{{ url('/banners/store') }}" id="FormReport" enctype="multipart/form-data">
              <div class="modal-body">
                {{ csrf_field() }}
                {{ Form::hidden('date', \Carbon\Carbon::now()) }}
                <div class="form-group">
                    {{ Form::label('usuario') }}
                    <select name="user" class="form-control">
	                  @if($usuarios != '[]')
	                    @foreach($usuarios as $us)
	                      <option value="{{ $us->id }}">{{ $us->name }}</option>
	                    @endforeach
	                  @endif
	                </select>
                </div>
                <div class="form-group">
	                {{ Form::label('Insertar imágen') }}
	                {{ Form::file('imagen', ['class'=>'form-control','required']) }}
	            </div>
              </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-muted" data-dismiss="modal">Descartar</button>
	            {{ Form::submit('Crear Banner', ['class'=>'btn btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
	          </div>
        	{{ Form::close() }}
        </div>
      </div>
    </div>

    <!-- Modal Edit Banners -->
    <div class="modal fade" id="Modal_edit_banners" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">EDITAR BANNER
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </h5>
          </div>
           <form method="POST" action="{{ url('/banners/update') }}" id="FormReport"  enctype="multipart/form-data">
              <div class="modal-body">
                {{ csrf_field() }}
                {{ Form::hidden('idbanner', null, ['id'=>'id_update']) }}
                {{ Form::hidden('date', \Carbon\Carbon::now()) }}
                <div class="form-group">
                    <select name="user" class="form-control" id="user_update">
                    	<option value=""></option>
		                @if($usuarios != '[]')
		                    @foreach($usuarios as $us)
		                      <option value="{{ $us->id }}">{{ $us->name }}</option>
		                    @endforeach
		                @endif
	                </select>
                </div>
                <div class="form-group">
	                {{ Form::label('Insertar imágen') }}
	                {{ Form::file('imagen', ['class'=>'form-control']) }}
	            </div>
	            <div class="form-group">
	            	<div class="col-md-6"></div>
	            	<div class="col-md-6">
	            		{{ Form::hidden('imagen_old', null, ['id'=>'imagen_input_old_update']) }}
	            		<img id="imagen_old_update" width="200px">
	            	</div>
	            </div>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn btn-default btn-custom-tmm btn-custom-tmm-muted" data-dismiss="modal">Descartar</button>
            {{ Form::submit('Guardar Banner', ['class'=>'btn btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
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
    function bannersEdit(data){
      $('#id_update').val(data.id);
      $('#user_update').val(data.idusers);
      $('#imagen_input_old_update').val(data.imagen);
      $("#imagen_old_update").attr("src", '/images/catalog/'+data.imagen);

      $("#Modal_edit_banners").modal();
    }
  </script>
@stop