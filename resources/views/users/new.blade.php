@extends('layouts.app')

@section('title-section','USUARIOS NUEVO')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li class="active">Nuevo usuario</li>
  </ol>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="white-box">
        <h3 class="box-title m-b-0">Nuevo usuario</h3><hr>
        {{ Form::open(['url'=>'usuarios/create','method'=>'post', 'class'=>'form row', 'autocomplete'=>'off']) }}
        	<div class="col-sm-6">
        		<div class="form-group">
        			{{ Form::label('Nombre de la empresa') }}
        			{{ Form::text('company', null,['class'=>'form-control','required']) }}
        		</div>
        		<div class="form-group">
        			{{ Form::label('Dirección') }}
        			{{ Form::text('address', null, ['class'=>'form-control','required']) }}
	        	</div>
        		<div class="form-group">
        			{{ Form::label('Teléfono') }}
        			{{ Form::text('phone', null, ['class'=>'form-control','required']) }}
        		</div>
        		<div class="form-group">
        			{{ Form::label('Localidad') }}
        			{{ Form::text('location', null, ['class'=>'form-control','required']) }}
        		</div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    {{ Form::label('Email (login)') }}
                    {{ Form::email('email', null, ['class'=>'form-control','required']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Password') }}
                    {{ Form::password('password', ['class'=>'form-control','required']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('Rol del usuario') }}
                    {{ Form::select('rol', ['admin' => 'Admin', 'user' => 'Cliente'], null, ['class'=>'form-control','required','placeholder' => 'Seleccione el Rol del usuario']) }}
                </div>
                <div class="form-group">
                </div>
        	</div>
        	<div class="col-sm-12 text-right">
        		<div class="form-group">
        			{{ Form::reset('Descartar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-muted']) }}
        			{{ Form::submit('Crear nuevo', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
        		</div>
        	</div>
        	{{ Form::close() }}
    </div>
@endsection 