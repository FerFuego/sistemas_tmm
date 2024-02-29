@extends('layouts.app')

@section('title-section','NUEVA MEDICION DE TERMOGRAFÍA')

@section('content')
    {{ Form::open(['url'=>'measurement/store','method'=>'post','class'=>'form','id'=>'form_medidas','enctype'=>'multipart/form-data']) }}
        {{ Form::hidden('iduser', $usuario) }}
        {{ Form::hidden('idbranch', $sucursal) }}
        {{ Form::hidden('type', 'termografia') }}
        {{ Form::hidden('sector', null, ['class'=>'form-control']) }}
        <div class="white-box">
            <h3 class="box-title m-b-0">Información básica de la medición</h3>
            <hr>
            <table class="table table-border-none">
            	<tbody>
            		<tr>
                        {{ Form::hidden('place',$branch->name, ['class' => 'form-control']) }}
                        <td class="text-right"><b>Fecha termografía</b></td>
                        <td>{{ Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control', 'required' => 'required']) }}</td>
                        {{-- <td class="text-right"><b>Notas </b></td>
            			<td>{{ Form::text('instrument', null, ['class'=>'form-control', 'placeholder'=> '', 'required' => 'required']) }}</td> --}}
            		</tr>
            	</tbody>
            </table>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-12 buttons col-md-12 col-lg-12 text-xs-center text-sm-center text-md-center text-lg-right">
                    <div class="col-sm-4 pull-right input-file1">
                        <label for="file1" id="input-file1"><i class="fa fa-paperclip"></i>Relevamiento de termografía</label>

                        {{-- Form::label('file1',' ') --}}
                        {{ Form::file('archivo_1', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file1','onchange'=>'nameFile(this.id)']) }}
                    </div>
                    <div class="col-sm-4 pull-right input-file2">
                    <label for="file2" id="input-file2"><i class="fa fa-paperclip"></i>Certificado de calibracion</label>

                        {{-- Form::label('file2',' ') --}}
                        {{ Form::file('archivo_2', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1', 'id'=>'file2','onchange'=>'nameFile(this.id)']) }}
                    </div>
                </div>
            </div>
        </div>
    <hr>

        {{ Form::hidden('iduser', $usuario) }}
        {{ Form::hidden('idbranch', $sucursal) }}
        {{ Form::hidden('type', 'termografia') }}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Detalle termografía</h3>
                    <hr>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Nº de análisis</label>
                            <div class="col-10">
                               {{ Form::text('value_num', 1, ['class'=>'form-control']) }}
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

                                <label for="Severo"">
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
                                <label for="Bueno" onclick="verifyValue('Bueno')" class="check"><span></span>  Bueno</label>

                                {{ Form::radio('state','Regular', false, ['id'=>'Regular','style'=>'display:none'])}}
                                <label for="Regular" onclick="verifyValue('Regular')" class="check"><span></span>  Regular</label>

                                {{ Form::radio('state','Malo', false, ['id'=>'Malo','style'=>'display:none'])}}
                                <label for="Malo" onclick="verifyValue('Malo')" class="check"><span></span>  Malo</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example2-text-input" class="col-2 col-form-label">Observaciones</label>
                            <div class="col-10">
                                {{ Form::textarea('observation', null, ['class'=>'form-control', 'id'=>'observ','rows'=>'1']) }}
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
@endsection

@section('javascript')
    <script>
        function verifyValue(val){
            var data = '<?php if(!empty($estados)) echo $estados; ?>';
            var content = JSON.parse(data);
            for (var i = content.length - 1; i >= 0; i--) {
                if(val == content[i].state) {
                    document.getElementById("observ").value = '';
                    document.getElementById("observ").value = content[i].observation;
                }
            };
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

        function ocultar(){
          document.getElementById("observ").value = "";
          var chtml="";
          $("#observ").html(chtml);
          document.getElementById("form_medidas").reset();
        }

        function nameFile(id){
            document.getElementById('input-'+id).innerHTML = document.getElementById(id).files[0].name;
        }
    </script>
@stop
