@extends('layouts.app')

@section('title-section','RANGOS DIFERENCIALES')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li class="active">Rangos/Diferencial</li>
  </ol>
@endsection

@section('content')
     <div class="white-box">
        <h3 class="box-title m-b-0">VALOR "BUENO","ADMISIBLE","RECOMENDADO"</h3><hr>
        {{ Form::open(['url'=>'rangos/valores/update/'.$values_cyd->id,'method'=>'post','class'=>'form row']) }}
        {{ csrf_field() }}
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::hidden('type', $values_cyd->type) }}
        {{ Form::hidden('icono', 'RANGO_1') }}
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::label('Desde')}}
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::text('since', $values_cyd->since, ['class'=>'form-control', 'required'=>'required']) }}
                </div>
              </div>
              <div class="col-sm-1 text-right">
                <div class="form-group">
                  {{ Form::label('Hasta') }}
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::text('until', $values_cyd->until, ['class'=>'form-control', 'required'=>'required']) }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::label('Observación') }}
                </div>
              </div>
              <div class="col-sm-10">
                <div class="form-group">
                  {{ Form::text('observation', $values_cyd->observation, ['class'=>'form-control', 'required'=>'required']) }}
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-12 text-right">
            <div class="form-group">
              <a href="javascript:void(0);" onclick="ocultar();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Resetear valores</a>
              {{ Form::submit('Guardar valor', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
            </div>
          </div>
        {{ Form::close() }}
    </div>

    <div class="white-box">
        <h3 class="box-title m-b-0">VALORES</h3><hr>
        @foreach($values as $val)
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                      {{ Form::label('Desde') }}
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      {{ Form::text('since', $val->since, ['class'=>'form-control','readonly'=>'true']) }}
                    </div>
                  </div>
                  <div class="col-sm-1 text-right">
                    <div class="form-group">
                      {{ Form::label('Hasta') }}
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      {{ Form::text('until', $val->until, ['class'=>'form-control','readonly'=>'true']) }}
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <div class="form-group">
                      {{ Form::label('Ícono') }}
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      @php 
                        switch($val->icono){ 
                          case('RANGO_1'):
                            echo Form::text('icono', 'ICONO BUENO', ['class'=>'form-control','readonly'=>'true']);
                          break;

                          case('RANGO_2'):
                            echo Form::text('icono', 'ICONO REGULAR', ['class'=>'form-control','readonly'=>'true']);
                          break;

                          case('RANGO_3'):
                            echo Form::text('icono', 'ICONO MALO', ['class'=>'form-control','readonly'=>'true']);
                          break;
                      
                          default:
                            echo Form::text('icono', 'ICONO BUENO', ['class'=>'form-control','readonly'=>'true']);
                          break;
                        } 
                      @endphp
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                      {{ Form::label('Observación') }}
                    </div>
                  </div>
                  <div class="col-sm-10">
                    <div class="form-group">
                      {{ Form::text('observation', $val->observation, ['class'=>'form-control','readonly'=>'true']) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 text-right">
                <form method="POST" action="{{ url('rangos-valores', [$val->id]) }}" id="FormDelete">
                  {{ csrf_field() }}
                  {{ Form::hidden('_method','DELETE') }}
                  {{ Form::hidden('id', $val->id) }}
                  {{ Form::submit('Elimnar valor',['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-delete']) }}
                  {{ Form::close() }}
              </div>
            </div>
          
          <div class="col-sm-12"><hr></div>
          
        @endforeach

    <div id="openForm" @if (session('status')) @else style="display: none;" @endif >
        {{ Form::open(['url'=>'rangos/valores/new','method'=>'post','class'=>'form row']) }}
        {{ Form::hidden('idrange', $range->id) }}
        {{ Form::hidden('type', $range->type) }}
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::label('Desde')}}
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::text('since', null, ['class'=>'form-control', 'required'=>'required']) }}
                </div>
              </div>
              <div class="col-sm-1 text-right">
                <div class="form-group">
                  {{ Form::label('Hasta') }}
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::text('until', null, ['class'=>'form-control', 'required'=>'required']) }}
                </div>
              </div>
              <div class="col-sm-2 text-right">
                <div class="form-group">
                  {{ Form::label('Ícono') }}
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::select('icono', [''=>'','RANGO_1' => 'ICONO BUENO', 'RANGO_2' => 'ICONO REGULAR', 'RANGO_3' => 'ICONO MALO'], null, ['class' => 'form-control', 'required'=>'required']) }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  {{ Form::label('Observación') }}
                </div>
              </div>
              <div class="col-sm-10">
                <div class="form-group">
                  {{ Form::text('observation', null, ['class'=>'form-control', 'required'=>'required']) }}
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-12 text-right">
            <div class="form-group">
              <a href="javascript:void(0);" onclick="ocultar();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Descartar</a>
                {{ Form::submit('Guardar valor', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-edit']) }}
                {{ Form::submit('Guardar valor y crear nuevo', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active', 'name'=>'nuevo', 'id'=>'nuevo']) }}
            </div>
          </div>
        {{ Form::close() }}
        </div>
      <a href="javascript:void(0);" id="newBtn" onclick="openForm();" class="btn btn-default btn-custom-tmm btn-custom-tmm-active" @if (!session('status')) @else style="display: none;" @endif >Nuevo valor</a>
    </div>

    <div class="white-box">
        <h3 class="box-title m-b-0">EQUIVALENCIAS</h3><hr>

        @foreach($equivalence as $quiv)
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::label('Código') }}
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::text('letras', $quiv->code, ['class'=>'form-control','readonly'=>'true']) }}
                  </div>
                </div>
                <div class="col-sm-1 text-right">
                  <div class="form-group">
                    {{ Form::label('valor') }}
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::text('valor', $quiv->value, ['class'=>'form-control','readonly'=>'true']) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::label('Observación') }}
                  </div>
                </div>
                <div class="col-sm-10">
                  <div class="form-group">
                    {{ Form::text('observation', $quiv->observation, ['class'=>'form-control','readonly'=>'true']) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 text-right">
              <form method="POST" action="{{ url('rangos-quivalence', [$quiv->id]) }}" id="FormDelete">
                {{ csrf_field() }}
                {{ Form::hidden('_method','DELETE') }}
                {{ Form::hidden('id', $quiv->id) }}
                {{ Form::submit('Elimnar valor',['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-delete']) }}
                {{ Form::close() }}
            </div>
          </div>
         
        <div class="col-sm-12"><hr></div>
        
        @endforeach

        <div id="openForm2" @if (session('status')) @else style="display: none;" @endif >
          {{ Form::open(['url'=>'rangos/quivalence/new','method'=>'post','class'=>'form row']) }}
          {{ Form::hidden('idrange', $range->id) }}
          {{ Form::hidden('type', $range->type) }}
          {{ Form::hidden('nuevo-equiv') }}
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::label('Código')}}
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::text('code', null, ['class'=>'form-control', 'required'=>'required']) }}
                  </div>
                </div>
                <div class="col-sm-1 text-right">
                  <div class="form-group">
                    {{ Form::label('Valor') }}
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::text('value', null, ['class'=>'form-control',  'id'=>'val_0', 'onchange'=>'verify_value(this.value, this.id);return false;', 'required'=>'required']) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    {{ Form::label('Observación') }}
                  </div>
                </div>
                <div class="col-sm-10">
                  <div class="form-group">
                    {{ Form::text('observation', null, ['class'=>'form-control', 'required'=>'required']) }}
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12 text-right">
              <div class="form-group">
                <a href="javascript:void(0);" onclick="ocultar();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Descartar</a>
                {{ Form::submit('Guardar valor', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-edit','id'=>'nueva-equiv']) }}
                {{ Form::submit('Guardar valor y crear nuevo', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active', 'name'=>'nuevo-equiv', 'id'=>'nuevo-equiv']) }}
              </div>
            </div>
          {{ Form::close() }}
      </div>
      <a href="javascript:void(0);" id="newBtnEquiv" onclick="openForm2();" class="btn btn-default btn-custom-tmm btn-custom-tmm-active" @if (!session('status')) @else style="display: none;" @endif >Nuevo valor</a>
    </div>

    <div class="white-box">
      <h3 class="box-title m-b-0">CRITICIDAD</h3><hr>
       {{ Form::open(['url'=>'rangos/criticidad/'.$critical[0]->id,'method'=>'post','class'=>'form','id'=>'rangos_update']) }}
          {{ csrf_field() }}
          {{ Form::hidden('_method', 'PUT') }}
          {{ Form::hidden('idranges', $range->id) }}
          {{ Form::hidden('type', $range->type) }}
          <div class="form-group row">
              {{ Form::label('Normal', null, ['class'=>'col-1 col-form-label']) }}
              <label for="example2-text-input" class="col-1 col-form-label"><i class="fa fa-circle text-success"></i></label>
              <div class="col-10">
                   <div class="form-group row">
                        {{ Form::label('Desde', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-2">
                          {{ Form::text('desde_1', $critical[0]->since_1, ['class'=>'form-control','id'=>'desde_1', 'required'=>'required']) }}
                        </div>
                        {{ Form::label('Hasta', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-2">
                          {{ Form::text('hasta_1', $critical[0]->until_1, ['class'=>'form-control','id'=>'hasta_1', 'required'=>'required']) }}
                        </div>
                        {{--  {{ Form::label('Observación', null, ['class'=>'col-2 col-form-label text-right']) }}
                        <div class="col-6">  --}}
                          {{ Form::hidden('observ_1', $critical[0]->observation_1, ['class'=>'form-control','id'=>'observ_1', 'required'=>'required']) }}
                        {{--  </div>  --}}
                    </div>

              </div>
          </div>
          {{--<div class="form-group row">
              {{ Form::label('Incipiente', null, ['class'=>'col-1 col-form-label']) }}
              <label for="example2-text-input" class="col-1 col-form-label"><i class="fa fa-circle text-warning"></i></label>
              <div class="col-10">
                   <div class="form-group row">
                        {{ Form::label('Desde', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-1">
                          {{ Form::text('desde_2', $critical[0]->since_2, ['class'=>'form-control','id'=>'desde_2', 'required'=>'required']) }}
                        </div>
                        {{ Form::label('Hasta', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-1">
                            {{ Form::text('hasta_2', $critical[0]->until_2, ['class'=>'form-control','id'=>'hasta_2', 'required'=>'required']) }}
                        </div>
                        {{ Form::label('Observación', null, ['class'=>'col-2 col-form-label text-right']) }}
                        <div class="col-6">
                          {{ Form::text('observ_2', $critical[0]->observation_2, ['class'=>'form-control','id'=>'observ_2', 'required'=>'required']) }}
                        </div> 
                    </div>

              </div>
          </div>
          <div class="form-group row">
              {{ Form::label('Pronunciada', null, ['class'=>'col-1 col-form-label']) }}
              <label for="example2-text-input" class="col-1 col-form-label"><i class="fa fa-circle text-warning"></i></label>
              <div class="col-10">
                   <div class="form-group row">
                        {{ Form::label('Desde', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-1">
                          {{ Form::text('desde_3', $critical[0]->since_3, ['class'=>'form-control','id'=>'desde_3', 'required'=>'required']) }}
                        </div>
                        {{ Form::label('Hasta', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-1">
                          {{ Form::text('hasta_3', $critical[0]->until_3, ['class'=>'form-control','id'=>'hasta_3', 'required'=>'required']) }}
                        </div>
                         {{ Form::label('Observación', null, ['class'=>'col-2 col-form-label text-right']) }}
                        <div class="col-6">
                          {{ Form::text('observ_3', $critical[0]->observation_3, ['class'=>'form-control','id'=>'observ_3', 'required'=>'required']) }}
                        </div> 
                    </div>

              </div>
          </div> --}}
          <div class="form-group row">
              {{ Form::label('Severa', null, ['class'=>'col-1 col-form-label']) }}
              <label for="example2-text-input" class="col-1 col-form-label"><i class="fa fa-circle text-danger"></i></label>
              <div class="col-10">
                   <div class="form-group row">
                        {{ Form::label('Desde', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-2">
                          {{ Form::text('desde_4', $critical[0]->since_4, ['class'=>'form-control','id'=>'desde_4', 'required'=>'required']) }}
                        </div>
                        {{ Form::label('Hasta', null, ['class'=>'col-1 col-form-label text-right']) }}
                        <div class="col-2">
                          {{ Form::text('hasta_4', $critical[0]->until_4, ['class'=>'form-control','id'=>'hasta_4', 'required'=>'required']) }}
                        </div>
                        {{-- {{ Form::label('Observación', null, ['class'=>'col-2 col-form-label text-right']) }}
                        <div class="col-6"> --}}
                            {{ Form::hidden('observ_4', $critical[0]->observation_4, ['class'=>'form-control','id'=>'observ_4', 'required'=>'required']) }}
                        {{-- </div> --}}
                    </div>
              </div>
          </div>
          <div class="col-sm-12 text-right">
            <div class="form-group">
              <a href="javascript:void(0)" onClick="resetearValores();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Resetear valores</a>
              {{ Form::submit('Guardar valor máximo', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
            </div>
          </div>
        {{ Form::close() }}
    </div>
@endsection 
@section('javascript')
  <script type="text/javascript">
    function descartarValores(){
      $('#value_max').val(0);
      $('#observation').val('valores no especificados');
      $('#recomendation').val('valores no especificados');
      $('#rangos_value').submit();
    }

    function resetearValores(){
      $('#desde_1').val(0);
      $('#hasta_1').val(0);
      $('#observ_1').val('Normal');

      $('#desde_2').val(0);
      $('#hasta_2').val(0);
      $('#observ_2').val('Incipiente');

      $('#desde_3').val(0);
      $('#hasta_3').val(0);
      $('#observ_3').val('Pronunciada');

      $('#desde_4').val(0);
      $('#hasta_4').val(0);
      $('#observ_4').val('Severa');

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

    function openForm2(){
      document.getElementById('newBtnEquiv').style.display = 'none';
      document.getElementById('openForm2').style.display = 'block';
    }

    function ocultar2(){
      document.getElementById('openForm2').style.display = 'none';
      document.getElementById('newBtnEquiv').style.display = 'inline-block';
    }
    function verify_value(val, id){
        var data = '<?php if(!empty($values)) echo $values; ?>';
        var content = JSON.parse(data);
        var ban = false;

        for (var i = 1; i <= Object.keys(content).length; i++) {
          var min = parseFloat(content[i].since);
          var max = parseFloat(content[i].until);
          if(parseFloat(val) >=  min && parseFloat(val) <= max) {
            document.getElementById('nuevo-equiv').disabled = false;
            document.getElementById('nueva-equiv').disabled = false;
            ban=true;
          }
        }

        if(ban==false){
          alert('El valor no puede superar el maximo rango.');
          document.getElementById('nuevo-equiv').disabled = true;
          document.getElementById('nueva-equiv').disabled = true;
        }
    }
  </script>
@stop