@extends('layouts.app')

@section('title-section','NUEVA MEDICION DE PUESTA A TIERRA')

@section('content')
    {{ Form::open(['url'=>'measurement/store','method'=>'post','class'=>'form','id'=>'form_medidas','enctype'=>'multipart/form-data']) }}
    	{{ Form::hidden('iduser', $usuario) }}
    	{{ Form::hidden('idbranch', $sucursal) }}
    	{{ Form::hidden('type', 'pat') }}
	    <div class="white-box">
	        <h3 class="box-title m-b-0">Información básica de la medición</h3>
	        <hr>
	        <table class="table table-border-none">
	        	<tbody>
	        		<tr>
	        			<td class="text-right"><b>Fecha</b></td>
	        			<td>{{ Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control', 'required' => 'required']) }}</td>
	        			<td class="text-right"><b>Instrumento</b></td>
	        			<td>{{ Form::text('instrument', null, ['class'=>'form-control', 'required' => 'required']) }}</td>
	        		</tr>
	        		<tr>
	        			<td class="text-right"><b>Reglamentación</b></td>
	        			<td>{{ Form::text('regulation', null, ['class' => 'form-control', 'required' => 'required']) }}</td>
	        			<td class="text-right"><b>Establecimiento</b></td>
	        			<td>{{ Form::text('place', $branch->name,['class' => 'form-control', 'readonly' => 'true', 'required' => 'required']) }}</td>
	        		</tr>
	        	</tbody>
	        </table>
	        <hr>
	        <div class="row">
	    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">	    				
        			{{ Form::checkbox('resolution',null, false, ['id'=>'resolution', 'style'=>'display:none']) }}
	    			<label for="resolution" class="check"><span></span>	Pertenece a resolución SRT 900/2015</label>    			
	          	</div>
	          	<div class="col-xs-12  buttons col-sm-12 col-md-12 col-lg-9 text-xs-center text-sm-center text-md-center text-lg-right">
      				<div class="col-sm-4 pull-right input-file1">
					  <label for="file1" id="input-file1"> <i class="fa fa-paperclip"></i>Protocolo SRT 900/2015</label>
      					{{-- Form::label('file1',' ') --}}
      					{{ Form::file('archivo_1', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file1','onchange'=>'nameFile(this.id)']) }}
      				</div>
      				<div class="col-sm-4 pull-right input-file2">
					  <label for="file2" id="input-file2"> <i class="fa fa-paperclip"></i>Certificado de calibracion</label>
      					{{-- Form::label('file2',' ') --}}
      					{{ Form::file('archivo_2', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file2','onchange'=>'nameFile(this.id)']) }}
      				</div>
      				<div class="col-sm-4 pull-right input-file3">
					  <label for="file3" id="input-file3"> <i class="fa fa-paperclip"></i>Imagen de crokis de la planta</label>
      					{{-- Form::label('file3',' ') --}}
      					{{ Form::file('archivo_3', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file3','onchange'=>'nameFile(this.id)']) }}
      				</div>
	          	</div>
	        </div>
	    </div>
    <hr>
    	{{ Form::hidden('iduser', $usuario) }}
    	{{ Form::hidden('idbranch', $sucursal) }}
    	{{ Form::hidden('type', 'pat') }}
	    <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
		        <div class="white-box">
		        	<div>
		        		{{ Form::file('image_1',['class'=>'dropify','id'=>'input-file-now-custom-2','data-height'=>'300']) }}
	                </div>
			    </div>	
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
		        <div class="white-box">
		            <h3 class="box-title">Detalle medición</h3>
		            <hr>
		            <table class="table table-border-none">
	            		<tr>
	            			<td><b>Detalle</b></td>
	            			<td class="col-md-10">
	            				{{ Form::text('detalles', null, ['class'=>'form-control', 'required' => 'required'])}}
	            			</td>
	            		</tr>
	            		<tr>
	            			<td><b>Sector</b></td>
	            			<td class="col-md-10">
	            				{{ Form::text('sector', null, ['class'=>'form-control', 'required' => 'required'])}}
	            			</td>
	            		</tr>
	            		<tr>
	            			<td><b>Valor</b></td>
	            			<td class="col-md-10">
	            				{{ Form::text('value', null, ['class'=>'form-control','id'=>'v_value', 'onchange'=>'verify_value(this.value);return false;','step'=>'.01','required' => 'required']) }}
	            			</td>
	            		</tr>
	            		<tr>
	            			<td><b>Valor máximo admisible</b></td>
	            			<td class="col-md-10">
	            				{{ Form::number('value_max', $rangos[0]->value_max, ['class'=>'form-control','readonly'=>'true','id'=>'v_max','step'=>'.01','required' => 'required']) }}
	            			</td>
	            		</tr>
	            		<tr>
	            			<td>
	            				<b>Observación</b>
	            			</td>
	            			<td class="col-md-10">
				                {{ Form::textarea('observation', null, ['class'=>'form-control','rows'=>'3','id'=>'piezas']) }}
	            			</td>
	            		</tr>
	            		<tr>
	            			<td>
	            				<b>Recomendación</b>
	            			</td>
	            			<td class="col-md-10">
	            				<div id="piezas2" class="form-control" style="overflow: auto; width: 100%; height: 100px; border: 1px solid #e4e7ea; color:#999; padding-left: 5px">
				                </div>
	            			</td>
	            		</tr>
	            		<tr>
	            			<td></td>
	            			<td class="col-md-10">
	            				{{ Form::textarea('other', null, ['class'=>'form-control','rows'=>'3']) }}
	            			</td>
	            		</tr>
		            </table>
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
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript">
		function nameFile(id){
			document.getElementById('input-'+id).innerHTML = document.getElementById(id).files[0].name;
		}

		function verify_value(val){
			
			var max = document.getElementById("v_max").value;
			
			$.ajax({
			        data: "max="+ max +"&val="+ val + "&_token={{ csrf_token()}}",
			        url: "{{ route('gethint')}}",
			        method: "POST",
			        beforeSend: function(){
                        $("#resultado").html("Procesando, espere por favor...");
	                },
	                success: function(data){

	                	if(data.datos == false){
	                		alert(data.sms);
	                		document.getElementById("guard_value").disabled = true; 
	                		document.getElementById("nuevo").disabled = true; 
	                		return;
	                	}

	                    var chtml="";
                        for (datas in data.observation) {
                        	chtml += data.observation[datas]+'\n';
                        };
	                    $("#piezas").html(chtml);

                        var dhtml="";
                        for (datas in data.datos) {
                          dhtml+= data.datos[datas]+'<br>';
                        };
	                    $("#piezas2").html(dhtml);

	                    document.getElementById("guard_value").disabled = false; 
	                    document.getElementById("nuevo").disabled = false; 
	                }
			    });
		}

		function ocultar(){
	      document.getElementById("piezas").value = "";
	      document.getElementById("piezas2").value = "";
	      var chtml="";
	      $("#piezas").html(chtml);
	      var dhtml="";
	      $("#piezas2").html(dhtml);
	      document.getElementById("form_medidas").reset();
	    }
	</script>
@stop

