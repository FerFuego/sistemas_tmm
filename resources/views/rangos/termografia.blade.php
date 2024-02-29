@extends('layouts.app')

@section('title-section','RANGOS TERMOGRAFÍA')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li class="active">Rangos/termografía</li>
  </ol>
@endsection

@section('content')
    <div class="white-box">
       <h3 class="box-title m-b-0">OBSERVACIONES PRECARGADAS</h3><hr>
        <div id="return">
            <div class="row">
                @foreach($range as $ra)
                  <div class="col-sm-2">
                    <div class="form-group">
                      {{ Form::label('observación') }}
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-group">
                       @if($range->count() > 1)
                        {{ Form::text('description', $ra->description, ['class'=>'form-control','data-id'=>$ra->id,'id'=>$ra->id,'readonly'=>'true']) }}
                       @else
                        {{ Form::text('description', $ra->description, ['class'=>'form-control','data-id'=>$ra->id,'id'=>$ra->id]) }}
                       @endif
                    </div>
                  </div>
                  <div class="col-sm-1 range-trash">
                    @if($range->count() > 1)
                      <a href="{!! route('rangos/delete', [$ra->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
                    @else
                      <a href="#" onclick="verify_value({{$ra->id}})" class="fa-link-tmm text-info"><i class="icon-pencil" id="i_{{$ra->id}}"></i></a>
                    @endif
                  </div>
                @endforeach
            </div>
        </div>
        <div id="openForm" @if (session('status')) @else style="display: none;" @endif >
        {{  Form::open(['route'=>'rangeTermoNew','method'=>'post', 'class'=>'form row', 'id'=>'myForm']) }}
            {{ csrf_field() }}
            <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::label('Observación') }}
                </div>
              </div>
              <div class="col-sm-9">
                <div class="form-group">
                  {{ Form::hidden('type', 'termografia', ['class'=>'form-control','id'=>'type']) }}
                  {{ Form::text('desc', null, ['class'=>'form-control','id'=>'desc', 'required'=>'required']) }}
                </div>
              </div>
            <div class="col-sm-11 text-right">
              <div class="form-group">
                <a href="javascript:void(0);" onclick="ocultar();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Descartar</a>
                {{ Form::submit('Guardar descripción', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-edit']) }}
                {{ Form::submit('Guardar y agregar descripción', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active', 'name'=>'nuevo', 'id'=>'nuevo']) }}
              </div>
            </div>
        {{ Form::close() }}
        </div>
        <a href="javascript:void(0);" id="newBtn" onclick="openForm();" class="btn btn-default btn-custom-tmm btn-custom-tmm-active" @if (!session('status')) @else style="display: none;" @endif >Nueva descripción</a>
    </div>

    @if(isset($states))
      <div class="white-box">
         <h3 class="box-title m-b-0">ESTADO DEL TABLERO</h3><hr>
          {{ Form::open(['url'=>'rangos-estados/'.$range[0]->id,'method'=>'post','class'=>'form','id'=>'rangos_update']) }}
            {{ csrf_field() }}
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::hidden('type', $range[0]->type) }}
            @php $i = 1; @endphp
            @foreach($states as $st)
              <div class="form-group row">
                  <div class="col-1">
                    {{ Form::label('Bueno', $st->state, ['class'=>'col-1 col-form-label']) }}
                  </div>
                  <div class="col-1">
                    <label for="example2-text-input" class="col-1 col-form-label">
                      @php
                        switch($st->state){
                          case('Bueno'): echo'<img src="'.asset('images/normal_inactive.png').'" width="25px">'; break;
                          case('Regular'): echo'<img src="'.asset('images/estable_inactive.png').'" width="25px">'; break;
                          case('Malo'):echo'<img src="'.asset('images/malo_inactive.png').'" width="25px">'; break;
                          default: echo'<img src="'.asset('images/normal_inactive.png').'" width="25px">'; break; 
                        }
                      @endphp
                    </label>
                    {{ Form::hidden('state[]', $st->state) }}
                  </div>
                  <div class="col-10">
                     <div class="form-group row">
                        <div class="col-2">
                          {{ Form::label('Observación', null, ['class'=>'col-1 col-form-label text-right']) }}
                        </div>
                          <div class="col-10">
                            {{ Form::text('observation[]',$st->observation, ['class'=>'form-control','id'=>'observ_'.$i, 'required'=>'required' ]) }}
                          </div>
                      </div>
                  </div>
              </div>
              @php $i++; @endphp
            @endforeach
            <div class="col-sm-12 text-right">
              <div class="form-group">
                <a href="javascript:void(0)" onClick="resetearValores();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Resetear valores</a>
                {{ Form::submit('Guardar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
              </div>
            </div>
          {{ Form::close() }}
      </div>
    @endif
    
@endsection 
@section('javascript')
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript">
    function verify_value(id){

      var type = 'termografia';
      var termografia = document.getElementById(id).value;
          
      $.ajax({
              data: "id="+ id +"&type="+ type +"&val="+ termografia +"&_token={{ csrf_token()}}",
              url: "{{ route('getTermData')}}",
              method: "POST",
              beforeSend: function(){
                    $("#resultado").html("Procesando, espere por favor...");
              },
              success: function(data){
                   document.getElementById(id).value = data.datos; 
                   var element = document.getElementById('i_'+id);
                   element.classList.remove("icon-pencil");
                   element.classList.add("icon-check");
              }
          });
    }

    function resetearValores(){

      $('#observ_1').val('valores no especificados');
      $('#observ_2').val('valores no especificados');
      $('#observ_3').val('valores no especificados');

      $('#rangos_update').submit();
    }
    function openForm(){
      document.getElementById('newBtn').style.display = 'none';
      document.getElementById('openForm').style.display = 'block';
    }

    function ocultar(){
      document.getElementById('openForm').style.display = 'none';
      document.getElementById('newBtn').style.display = 'inline-block';
    }
  </script>
@stop
