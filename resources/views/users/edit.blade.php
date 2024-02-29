@extends('layouts.app')

@section('title-section','EDITAR USUARIO "'. $user->name .'"')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li class="active">Editar usuario</li>
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
        <ul class="nav nav-pills nav-pills-tmm">
          <li class="nav-item active">
            <a class="nav-link nav-link-pill-tmm" id="home-tab" data-toggle="tab" href="#edit" role="tab" onClick="remove()">Info usuario</a>
          </li>
          @if(Auth::user()->hasRole('admin'))
          <li class="nav-item">
            <a class="nav-link nav-link-pill-tmm" id="home-tab" data-toggle="tab" href="#sucursal" role="tab" onClick="remove()">Sucursales</a>
          </li>
          @endif
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
            {{ Form::open(['route'=>['usuarios.update', $user], 'method'=>'put', 'class'=>'form row', 'autocomplete'=>'off']) }}
                <div class="col-sm-6">
                  <div class="form-group">
                    {{ Form::label('Nombre de la empresa') }}
                    {{ Form::text('company', $user->company,['class'=>'form-control','required']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Dirección') }}
                    {{ Form::text('address', $user->address, ['class'=>'form-control','required']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Teléfono') }}
                    {{ Form::text('phone', $user->phone, ['class'=>'form-control','required']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Localidad') }}
                    {{ Form::text('location', $user->location, ['class'=>'form-control','required']) }}
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    {{ Form::label('Email (login)') }}
                    {{ Form::email('email', $user->email, ['class'=>'form-control','required']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Password') }}
                    {{ Form::password('password', ['class'=>'form-control','placeholder'=>'*******']) }}
                    {{ Form::hidden('old_pass', $user->password)}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Rol del usuario') }}
                    @php
                      $u = $user->roles()->first();
                    @endphp
                    {{ Form::select('rol', ['admin' => 'Admin', 'user' => 'Cliente'], $u->name, ['class'=>'form-control','required','placeholder' => 'Seleccione el Rol del usuario']) }}
                  </div>
                  <div class="form-group">
                  </div>
                  {{-- @if(Auth::user()->hasRole('admin'))
                    <div class="form-group">
                      {{ Form::label('Mediciones') }}<br>
                      @if (in_array('pat', explode(',', $user->mediciones)))
                        {{ Form::checkbox('pat', 'pat', true) }}
                      @else
                        {{ Form::checkbox('pat', 'pat') }}
                      @endif
                      {{ Form::label('PAT') }}

                      @if (in_array('continuidad', explode(', ', $user->mediciones)))
                        {{ Form::checkbox('continuidad', 'continuidad', true) }}
                      @else
                        {{ Form::checkbox('continuidad', 'continuidad') }}
                      @endif
                      {{ Form::label('Continuidad') }}

                      @if (in_array('diferencial',  explode(', ', $user->mediciones)))
                        {{ Form::checkbox('diferencial', 'diferencial', true) }}
                      @else
                        {{ Form::checkbox('diferencial', 'diferencial') }}
                      @endif
                      {{ Form::label('Diferenciales') }}

                      @if (in_array('termografia', explode(', ', $user->mediciones)))
                        {{ Form::checkbox('termografia', 'termografia', true) }}
                      @else
                        {{ Form::checkbox('termografia', 'termografia') }}
                      @endif
                      {{ Form::label('Termografía') }}
                    </div>
                  @endif --}}
                </div>
                <div class="col-sm-12 text-right">
                  <div class="form-group">
                   @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('usuarios.destroy', $user->id) }}" onclick="return confirm('¿Seguro deseas eliminar el usuario?');" class="btn btn-default btn-custom-tmm btn-custom-tmm-delete">Eliminar</a>
                    <a href="javascript:void(0);" onclick="location.reload();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Descartar</a>
                    @endif
                    {{ Form::submit('Guardar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
                  </div>
                </div>
            {{ Form::close() }}
          </div>
          <div class="tab-pane fade" id="sucursal" role="tabpanel" aria-labelledby="sucursal-tab">
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                        <a href="#" data-toggle="modal" data-target="#new-sucursal" class="btn btn-default btn-custom-tmm btn-custom-tmm-active">Crear nueva sucursal</a><br><br>
                        <table class="table table-bordered text-center">
                          <thead>
                            <tr>
                              {{-- <th scope="col" class="text-center">Nº de Sucursal</th> --}}
                              <th scope="col" class="text-center">Nombre</th>
                              <th scope="col" class="text-center">Dirección</th>
                              <th scope="col" class="text-center">Localidad</th>
                              <th scope="col" class="text-center">Provincia</th>
                              <th scope="col" class="text-center">Email</th>
                              <th scope="col" class="text-center"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($branchoffs as $branchoff)
                              <tr>
                                {{-- <th scope="row" class="text-center">{{ $branchoff->id }}</th> --}}
                                <td>{{ $branchoff->name }}</td>
                                <td>{{ $branchoff->address }}</td>
                                <td>{{ $branchoff->location }}</td>
                                <td>{{ $branchoff->province }}</td>
                                <td>{{ $branchoff->email }}</td>
                                <td>
                                    <a href="{!! route('usuarios.sucursal', [$user->id, $branchoff->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
                                    <a href="javascript:void(0);" onClick="branchEdit({{ $branchoff }})" class="fa-link-tmm text-info"><i class="icon-pencil"></i></a>
                                    <a href="{{ route('branchoffice.destroy', $branchoff->id) }}" onclick="return confirm('¿Seguro deseas eliminar la sucursal?');" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
          </div>
        </div>
    </div>
    <!-- Modal Create-->
    <div class="modal fade" id="new-sucursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            {{ Form::open(['url'=>'branchoffice/create', 'method'=>'post', 'class'=>'form row']) }}
                {{ Form::hidden('idusers', $user->id) }}
                <div class="col-sm-12">
                  <div class="form-group">
                    {{ Form::label('Nombre') }}
                    {{ Form::text('name', null, ['class'=>'form-control','required']) }}
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
                    {{ Form::label('Diferencial') }}
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

    <!-- Modal Update-->
    <div class="modal fade" id="update-sucursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">EDITAR SUCURSAL
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </h5>
          </div>
          <div class="modal-body">
            {{ Form::open(['url'=>'branchoffice/update', 'method'=>'post', 'class'=>'form row']) }}
                {{ Form::hidden('idusers', null, ['id'=>'id_update']) }}
                <div class="col-sm-12">
                  <div class="form-group">
                    {{ Form::label('Nombre') }}
                    {{ Form::text('name', null, ['class'=>'form-control','id'=>'name_update','required']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Dirección') }}
                    {{ Form::text('address', null, ['class'=>'form-control','id'=>'address_update']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Teléfono') }}
                    {{ Form::text('phone', null, ['class'=>'form-control','id'=>'phone_update']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Email (login)') }}
                    {{ Form::email('email', null, ['class'=>'form-control','id'=>'email_update']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Localidad') }}
                    {{ Form::text('location', null, ['class'=>'form-control','id'=>'location_update']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Provincia') }}
                    {{ Form::text('province', null, ['class'=>'form-control','id'=>'province_update']) }}
                  </div>
                  {{-- <div class="form-group">
                    {{ Form::label('Mediciones') }}<br>
                    <input type="checkbox" name="pat" id="pat" value="pat" checked="">
                    {{ Form::label('PAT') }}
                    <input type="checkbox" name="continuity" id="continuidad" value="continuidad" checked="">
                    {{ Form::label('Continuidad') }}
                    <input type="checkbox" name="differentials" id="diferencial" value="diferencial" checked="">
                    {{ Form::label('Diferencial') }}
                    <input type="checkbox" name="thermography" id="termografia" value="termografia" checked="">
                    {{ Form::label('Termografía') }}
                  </div> --}}
                </div>
                <div class="col-sm-12 text-right">
                  <hr>
                  <div class="form-group">
                    {{ Form::reset('Descartar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-muted',' data-dismiss'=>'modal']) }}
                    {{ Form::submit('Guardar Cambios', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
                  </div>
                </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->
@endsection
@section('javascript')
    <script>
        function remove(){
            $("#edit").removeClass("show");
        }

        function branchEdit(data){
          $('#id_update').val(data.id);
          $('#name_update').val(data.name);
          $('#address_update').val(data.address);
          $('#phone_update').val(data.phone);
          $('#email_update').val(data.email);
          $('#location_update').val(data.location);
          $('#province_update').val(data.province);
          // if(data.pat == "pat" || data.pat == "pat"){
          //   $('#pat').prop('checked', true);
          // }else{
          //   $('#pat').prop('checked', false);
          // }
          // if(data.continuity == "continuity" || data.continuity == "continuidad"){
          //   $('#continuidad').prop('checked', true);
          // }else{
          //   $('#continuidad').prop('checked', false);
          // }
          // if(data.differentials == "differentials" || data.differentials == "diferencial"){
          //   $('#diferencial').prop('checked', true);
          // }else{
          //   $('#diferencial').prop('checked', false);
          // }
          // if(data.thermography == "thermography" || data.thermography == "termografia"){
          //   $('#termografia').prop('checked', true);
          // }else{
          //   $('#termografia').prop('checked', false);
          // }

          $("#update-sucursal").modal();
        }
    </script>
@stop
