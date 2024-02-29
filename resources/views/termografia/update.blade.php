@extends('layouts.app')

@section('title-section','NUEVA MEDICION DE TERMOGRAFÍA')

@section('breadcrumbs')
    <ol class="breadcrumb">
    <li><a href="{{ url('usuarios/todos') }}">usuarios</a></li>
    <li><a href="{{ url('usuarios/'.$user->id.'/ver') }}">{{ $user->name}}</a></li>
    <li><a href="{{ url('usuarios/'.$user->id.'/sucursal/'.$branch->id) }}">{{ $branch->name}}</a></li>
    <li class="active">Nueva Termografía</li>
  </ol>
@endsection

@section('content')
    <form method="POST" action="{{ url('measurement/update', $medidas[0]->id) }}" class="form" id="FormUpdate" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ Form::hidden('iduser', $usuario) }}
        {{ Form::hidden('idbranch', $sucursal) }}
        {{ Form::hidden('type', 'termografia') }}
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::hidden('id', $medidas[0]->id) }}
        {{ Form::hidden('sector', null, ['class'=>'form-control']) }}
        <div class="white-box">
            <h3 class="box-title m-b-0">Información básica de la medición</h3>
            <hr>
            <table class="table table-border-none">
            	<tbody>
            		<tr>
            			<td class="text-right"><b>Fecha termografía</b></td>
            			<td>{{ Form::date('date', $medidas[0]->date, ['class' => 'form-control', 'required' => 'required']) }}</td>
            			{{-- <td class="text-right"><b>Notas</b></td>
            			<td>{{ Form::text('instrument', $medidas[0]->instrument, ['class'=>'form-control', 'placeholder'=> 'METREL MI-2088','required' => 'required']) }}</td> --}}
                        {{ Form::hidden('place', $medidas[0]->place,['class' => 'form-control','readonly'=>'true', 'required' => 'required']) }}
            		</tr>
            	</tbody>
            </table>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-12 buttons col-md-12 col-lg-12 text-xs-center text-sm-center text-md-center text-lg-right">
                    <div class="col-sm-4 pull-right input-file1">
                        @if(!empty($medidas[0]->archivo_1))
                            <div class="float_items">
                                <a href="{{asset('files/certificates/'.$medidas[0]->archivo_1)}}" title="ver" target="_blank"><i class="icon-eye text-merge"></i></a>
                                <a href="{!! url('certificado/'.$medidas[0]->id.'/archivo_1') !!}" title="eliminar"><i class="icon-trash text-danger"></i></a>
                                {{ Form::hidden('archivo_old_1', $medidas[0]->archivo_1 )}}
                            </div>
                            <label for="file1" id="input-file1"><i class="fa fa-paperclip"></i>{{ $medidas[0]->archivo_1 }}</label>
                        @else
                            <label for="file1" id="input-file1"><i class="fa fa-paperclip"></i>Relevamiento de termografía</label>
                        @endif

                        {{-- Form::label('file1',' ') --}}
                        {{ Form::file('archivo_1', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file1','onchange'=>'nameFile(this.id)']) }}
                    </div>
                    <div class="col-sm-4 pull-right input-file2">
                        @if(!empty($medidas[0]->archivo_2))
                            <div class="float_items">
                                <a href="{{asset('files/certificates/'.$medidas[0]->archivo_2)}}" title="ver" target="_blank"><i class="icon-eye text-merge"></i></a>
                                <a href="{!! url('certificado/'.$medidas[0]->id.'/archivo_2') !!}" title="eliminar"><i class="icon-trash text-danger"></i></a>
                                {{ Form::hidden('archivo_old_2', $medidas[0]->archivo_2 )}}
                            </div>
                            <label for="file2" id="input-file2"><i class="fa fa-paperclip"></i>{{ $medidas[0]->archivo_2 }}</label>
                        @else
                            <label for="file2" id="input-file2"><i class="fa fa-paperclip"></i>Certificado de calibracion</label>
                        @endif
                        {{-- Form::label('file2',' ') --}}
                        {{ Form::file('archivo_2', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file2','onchange'=>'nameFile(this.id)']) }}
                    </div>
                    {{ Form::hidden('archivo_3', null) }}
                </div>
            </div>
            <br><br>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                {{ Form::submit('Guardar y cargar mediciones', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
            </div>
        </div>
    {{ Form::close() }}
    <hr>

    @php $x=1; @endphp
    @foreach($valores as $val)
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="white-box">
                    <form method="POST" action="{{ url('values', $val->id) }}" id="FormUpdate" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ Form::hidden('iduser', $usuario) }}
                    {{ Form::hidden('idbranch', $sucursal) }}
                    {{ Form::hidden('type', 'termografia') }}
                    {{ Form::hidden('_method', 'PUT') }}
                    {{ Form::hidden('id', $val->id) }}
                    {{ Form::hidden('date', $val->date) }}
                    <h3 class="box-title m-b-0">Detalle termografía</h3>
                    <hr>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Nº de análisis</label>
                            <div class="col-10">
                               {{ Form::text('value_num', $val->value_num, ['class'=>'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example2-text-input" class="col-2 col-form-label">Detalle</label>
                            <div class="col-10">
                                {{ Form::text('title', $val->title, ['class'=>'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="example2-text-input" class="col-2 col-form-label">Observacion predeterminada</label>
                            <div class="col-10">
                               <?php 
                                    if(strpos($val->recommendation,'[')!==false){
                                        $string=false;
                                        foreach(json_decode($val->recommendation, true) as $obs){
                                            $string.= "- &nbsp;".$obs."\n";
                                        }
                                    }else{
                                        $string=json_decode($val->recommendation);
                                    }
                                ?>
                                <textarea name="recomendation" class="form-control" rows="5">{{ $string }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example2-text-input" class="col-2 col-form-label"></label>
                            <div class="col-10">
                                {{ Form::textarea('other', $val->other, ['class'=>'form-control', 'rows'=>'3']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('criterio', null, ['class'=>'col-2 col-form-label']) }}
                            <div class="col-10 radio_Termo">
                                @php 
                                    $array=array('Normal','Incipiente','Pronunciado','Severo'); 
                                @endphp

                                @foreach($array as $a)
                                    @if($val->criterion==$a)
                                        <label for="{{$val->criterion.$x}}">
                                            <input type="radio" name="criterion" value="{{$val->criterion}}" id="{{$val->criterion.$x}}" style="display: none;">
                                            <span class="check btn btn-default btn-custom-tmm btn-custom-tmm-muted @php if($a == 'Normal'){ print 'btn-custom-tmm-green'; } if($a == 'Pronunciado'){ print 'darker-yellow'; } if($a == 'Severo'){ print 'darker-red'; } if($a == 'Incipiente'){ print 'btn-custom-tmm-warning'; } @endphp aclarar" id="{{ $a.'_'.$x}}" onclick="opacity_update('{{$x}}','{{$a}}')">{{$val->criterion}}</span>
                                        </label>
                                    @else
                                        <label for="{{ $a.$x }}">
                                            <input type="radio" name="criterion" value="{{$a}}" id="{{$a.$x}}" style="display: none;">
                                            <span class="check btn btn-default btn-custom-tmm btn-custom-tmm-muted @php if($a == 'Normal'){ print 'btn-custom-tmm-green'; } if($a == 'Pronunciado'){ print 'darker-yellow'; } if($a == 'Severo'){ print 'darker-red'; } if($a == 'Incipiente'){ print 'btn-custom-tmm-warning'; } @endphp" id="{{ $a.'_'.$x}}" onclick="opacity_update('{{$x}}', '{{ $a}}')">{{ $a }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <h3>IMAGEN TERMOGRÁFICA</h3>
                                <div style="background-image: url('{{ asset('images/catalog/'.$val->image_1) }}')!important; background-size:cover;">
                                    {{ Form::file('image_1',['class'=>'dropify','id'=>'input-file-now-custom-1','data-height'=>'400']) }}
                                    {{ Form::hidden('image_1_old', $val->image_1)}}
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <h3>IMAGEN DIGITAL</h3>
                                <div style="background-image: url('{{ asset('images/catalog/'.$val->image_2) }}')!important; background-size:cover;">
                                     {{ Form::file('image_2',['class'=>'dropify','id'=>'input-file-now-custom-2','data-height'=>'400']) }}
                                     {{ Form::hidden('image_2_old', $val->image_2)}}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-xs-12">
                            <div style="background-image: url('{{ asset('images/catalog/'.$val->image_3) }}')!important; background-size:cover;">
                                 {{ Form::file('image_3',['class'=>'dropify','id'=>'input-file-now-custom-3','data-height'=>'200']) }}
                                 {{ Form::hidden('image_3_old', $val->image_3)}}
                            </div>
                        </div>
                        <br><hr>
                        <div class="form-group row">
                            <label for="example2-text-input" class="col-2 col-form-label">Estado del tablero</label>
                            <div class="col-6">
                                <?php $array=array('Bueno','Regular','Malo'); ?>
                                @foreach($array as $a)
                                    @if($val->state==$a)
                                        {{ Form::radio('state',$val->state, true, ['id'=>$val->state.$x,'style'=>'display:none'])}}
                                         <label for="{{ $val->state.$x }}" onclick="verifyValue({{$x}},'{{$val->state}}')" class="check"><span></span> {{ $val->state }}</label>
                                    @else
                                    {{ Form::radio('state',$a, false, ['id'=>$a.$x,'style'=>'display:none'])}}
                                         <label for="{{ $a.$x }}" onclick="verifyValue({{$x}},'{{$a}}')" class="check"><span></span> {{ $a }}</label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example2-text-input" class="col-2 col-form-label">Observaciones</label>
                            <div class="col-10">
                                <?php 
                                    if(strpos($val->observation,'[')!==false){
                                        $string=false;
                                        foreach(json_decode($val->observation, true) as $obs){
                                            $string .= "&#x25cf;&nbsp;".$obs."\n";
                                        }
                                    }else{
                                        $string=json_decode($val->observation);
                                    }
                                ?>
                                <textarea name="observation" class="form-control" id="observ_{{$x}}" rows="1">{{ $string }}</textarea>
                            </div>
                        </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                        {{ Form::submit('Guardar cambios', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-green']) }}
                    </div>
                    {{ Form::close() }}
                    <div class="pull-right" style="bottom:27px;position:absolute;right:260px;">
                        <form method="POST" action="{{ url('values', $val->id) }}" id="FormDelete">
                        {{ csrf_field() }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::hidden('id', $val->id) }}
                        {{ Form::submit('Eliminar',['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-delete']) }}
                        </form>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
        <hr>
        @php $x++; @endphp
    @endforeach

    <div id="openForm" @if (session('status')) @else style="display: none;" @endif >
        {{ Form::open(['url'=>'values/store','method'=>'post','class'=>'form','id'=>'form_medidas','name'=>'form_medidas','enctype'=>'multipart/form-data']) }}
                {{ Form::hidden('iduser', $usuario) }}
                {{ Form::hidden('idbranch', $sucursal) }}
                {{ Form::hidden('idmeasurement', $medidas[0]->id) }}
                {{ Form::hidden('type', $medidas[0]->type) }}
            <div class="row">
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	        <div class="white-box">
                        <h3 class="box-title m-b-0">Detalle termografía</h3>
                        <hr>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Nº de análisis</label>
                                <div class="col-10">
                                   {{ Form::text('value_num', $x, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example2-text-input" class="col-2 col-form-label">Detalle</label>
                                <div class="col-10">
                                    {{ Form::text('title', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example2-text-input" class="col-2 col-form-label">Observación predeterminada</label>
                                <div class="col-10">
                                    <?php $i=0; ?>
                                    @foreach($rangos as $ra)
                                        <input type='checkbox' name='recomendation[]' id="observation_{{$i}}" value='{{ $ra->description }}' style="display:none;"/>
                                        <label for="observation_{{$i}}" class="check"><span></span>{{ $ra->description }}</label>
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example2-text-input" class="col-2 col-form-label"></label>
                                <div class="col-10">
                                    {{ Form::textarea('other', null, ['class'=>'form-control','rows'=>'3']) }}
                                </div>
                            </div>
                            <div class="form-group row radio_Termo">
                                {{ Form::label('criterio', null, ['class'=>'col-2 col-form-label']) }}
                                <div class="col-10">
                                    <label for="Normal">
                                        <input type="radio" name="criterion" value="Normal" id="Normal" style="display: none;">
                                        <span class="check btn btn-default btn-custom-tmm btn-custom-tmm-green" id="btn_normal" onclick="opacity('btn_normal')">Normal</span>
                                    </label>
                                    
                                    <label for="Incipiente">
                                        <input type="radio" name="criterion" value="Incipiente" id="Incipiente" style="display: none;">
                                        <span class="check btn btn-default btn-custom-tmm btn-custom-tmm-warning" id="btn_incipiente" onclick="opacity('btn_incipiente')">Incipiente</span>
                                    </label>
                                    
                                    <label for="Pronunciado">
                                        <input type="radio" name="criterion" value="Pronunciado" id="Pronunciado" style="display: none;">
                                        <span class="check btn btn-default btn-custom-tmm btn-custom-tmm-warning darker-yellow" id="btn_pronunciado" onclick="opacity('btn_pronunciado')">Pronunciado</span>
                                    </label>

                                    <label for="Severo">
                                        <input type="radio" name="criterion" value="Severo" id="Severo" style="display: none;">
                                        <span class="check btn btn-default btn-custom-tmm btn-custom-tmm-active darker-red" id="btn_severo" onclick="opacity('btn_severo')">Severo</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <h3>IMAGEN TERMOGRÁFICA</h3>
                                    <div>
                                        {{ Form::file('image_1',['class'=>'dropify','id'=>'input-file-now-custom-1','data-height'=>'400']) }}
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h3>IMAGEN DIGITAL</h3>
                                    <div>
                                         {{ Form::file('image_2',['class'=>'dropify','id'=>'input-file-now-custom-2','data-height'=>'400']) }}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-xs-12">
                                <div>
                                     {{ Form::file('image_3',['class'=>'dropify','id'=>'input-file-now-custom-3','data-height'=>'200']) }}
                                </div>
                            </div>
                            <br><hr>
                            <div class="form-group row">
                                <label for="example2-text-input" class="col-2 col-form-label">Estado del tablero</label>
                                <div class="col-6 fingers">
                                    {{ Form::radio('state','Bueno', false, ['id'=>'Bueno','style'=>'display:none'])}}
                                    <label for="Bueno" onclick="verifyValue(0, 'Bueno')" class="check"><span></span>  Bueno</label>

                                    {{ Form::radio('state','Regular', false, ['id'=>'Regular','style'=>'display:none'])}}
                                    <label for="Regular" onclick="verifyValue(0, 'Regular')" class="check"><span></span>  Regular</label>

                                    {{ Form::radio('state','Malo', false, ['id'=>'Malo','style'=>'display:none'])}}
                                    <label for="Malo" onclick="verifyValue(0, 'Malo')" class="check"><span></span>  Malo</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example2-text-input" class="col-2 col-form-label">Observaciones</label>
                                <div class="col-10">
                                    {{ Form::textarea('observation', null, ['class'=>'form-control', 'id'=>'observ_0','rows'=>'1']) }}
                                </div>
                            </div>
        	        </div>
        	    </div>
            </div>

            <div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <a href="javascript:void(0);" onclick="ocultar();" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted">Descartar</a>
                        {{ Form::submit('Guardar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-edit','id'=>'guard_value']) }}
                        {{ Form::submit('Guardar y nueva medición', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active', 'name'=>'nuevo', 'id'=>'nuevo']) }}
        	    </div>
            </div>
        {{ Form::close() }}
    </div>
    <a href="javascript:void(0);" id="newBtn" onclick="openForm();" class="btn btn-default btn-custom-tmm btn-custom-tmm-active" @if (!session('status')) @else style="display: none;" @endif >Nueva medición</a>
@endsection 

@section('javascript')
    <script>
        function verifyValue(id, val){
            console.log(id + '-->' +val);
            var data = '<?php if(!empty($estados)) echo $estados; ?>';
            var content = JSON.parse(data);
            for (var i = content.length - 1; i >= 0; i--) {
                if(val == content[i].state) {
                    document.getElementById("observ_"+id).value = '';
                    document.getElementById("observ_"+id).value = content[i].observation;
                }
            };
        }

        function openForm(){
          document.getElementById('newBtn').style.display = 'none';
          document.getElementById('openForm').style.display = 'block';
        }


        function opacity(id){
            if(id == 'btn_normal'){
                $('#btn_normal').addClass("aclarar");
            }else{
                $('#btn_normal').removeClass("aclarar");
            }
            if(id == 'btn_incipiente'){
                $('#btn_incipiente').addClass("aclarar");
            }else{
                $('#btn_incipiente').removeClass("aclarar");
            }
            if(id == 'btn_pronunciado'){
                $('#btn_pronunciado').addClass("aclarar");
            }else{
                $('#btn_pronunciado').removeClass("aclarar");
            }
            if(id == 'btn_severo'){
                $('#btn_severo').addClass("aclarar");
            }else{
                $('#btn_severo').removeClass("aclarar");
            }
        }

        function opacity_update(id, vars){
            var tipos = ['Normal','Incipiente','Pronunciado','Severo'];
            for (i = 0; i < tipos.length; i++) { 
               if(vars == tipos[i]){
                    $('#'+tipos[i] +'_'+id).addClass("aclarar");
                }else{
                    $('#'+tipos[i] +'_'+id).removeClass("aclarar");
                }
            }
        }

        function ocultar(){
          document.getElementById('openForm').style.display = 'none';
          document.getElementById('newBtn').style.display = 'inline-block';
          document.getElementById("observ_0").value = "";
          var chtml="";
          $("#observ_0").html(chtml);
          document.getElementById("form_medidas").reset();
        }

        function nameFile(id){
            document.getElementById('input-'+id).innerHTML = document.getElementById(id).files[0].name;
        }
    </script>           
@stop
