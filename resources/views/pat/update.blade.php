@extends('layouts.app')

@section('title-section','NUEVA MEDICION DE PUESTA A TIERRA')

@section('breadcrumbs')
    <ol class="breadcrumb">
    <li><a href="{{ url('usuarios/todos') }}">usuarios</a></li>
    <li><a href="{{ url('usuarios/'.$user->id.'/ver') }}">{{ $user->name}}</a></li>
    <li><a href="{{ url('usuarios/'.$user->id.'/sucursal/'.$branch->id) }}">{{ $branch->name}}</a></li>
    <li class="active">Nuevo PAT</li>
  </ol>
@endsection

@section('content')
    <form method="POST" action="{{ url('measurement/update', $medidas[0]->id) }}" class="form" id="FormUpdate" enctype="multipart/form-data">
    	{{ csrf_field() }}
    	{{ Form::hidden('iduser', $usuario) }}
    	{{ Form::hidden('idbranch', $sucursal) }}
    	{{ Form::hidden('type', 'pat') }}
    	{{ Form::hidden('_method', 'PUT') }}
        {{ Form::hidden('id', $medidas[0]->id) }}
	    <div class="white-box">
	        <h3 class="box-title m-b-0">Información básica de la medición</h3>
	        <hr>
	        <table class="table table-border-none">
	        	<tbody>
	        		<tr>
	        			<td class="text-right"><b>Fecha</b></td>
	        			<td>{{ Form::date('date', $medidas[0]->date, ['class' => 'form-control', 'required' => 'required']) }}</td>
	        			<td class="text-right"><b>Instrumento</b></td>
	        			<td>{{ Form::text('instrument', $medidas[0]->instrument, ['class'=>'form-control', 'required' => 'required']) }}</td>
	        		</tr>
	        		<tr>
	        			<td class="text-right"><b>Reglamentación</b></td>
	        			<td>{{ Form::text('regulation', $medidas[0]->regulation, ['class' => 'form-control', 'required' => 'required']) }}</td>
	        			<td class="text-right"><b>Establecimiento</b></td>
	        			<td>{{ Form::text('place', $medidas[0]->place,['class' => 'form-control','readonly'=>'true', 'required' => 'required']) }}</td>
	        		</tr>
	        	</tbody>
	        </table>
	        <hr>
	        <div class="row">
	    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
	    				@if($medidas[0]->resolution =='on')
        				{{ Form::checkbox('resolution',null, true, ['id'=>'resolution', 'style'=>'display:none']) }}
        				@else
        				{{ Form::checkbox('resolution',null, false, ['id'=>'resolution', 'style'=>'display:none']) }}
        				@endif
	    			<label for="resolution" class="check"><span></span>	Pertenece a resolución SRT 900/2015</label>    			
	          	</div>
	          	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 text-xs-center text-sm-center text-md-center text-lg-right">
	      			<div class="col-sm-4 pull-right input-file1">
  						@if(!empty($medidas[0]->archivo_1))
  							<div class="float_items">
			          			<a href="{{asset('files/certificates/'.$medidas[0]->archivo_1)}}" target="_blank" title="ver"><i class="icon-eye text-merge"></i></a>
				        		<a href="{!! url('certificado/'.$medidas[0]->id.'/archivo_1') !!}" title="eliminar"><i class="icon-trash text-danger"></i></a>
			      				{{ Form::hidden('archivo_old_1', $medidas[0]->archivo_1 )}}
  							</div>
      						<label for="file1" id="input-file1"> <i class="fa fa-paperclip"></i>{{ $medidas[0]->archivo_1 }}</label>
  						@else
  							<label for="file1" id="input-file1"> <i class="fa fa-paperclip"></i>Protocolo SRT 900/2015</label>
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
							<label for="file2" id="input-file2"> <i class="fa fa-paperclip"></i>{{ $medidas[0]->archivo_2 }}</label>
						@else
      						<label for="file2" id="input-file2"> <i class="fa fa-paperclip"></i>Certificado de calibracion</label>
		  				@endif
      					{{-- Form::label('file2',' ') --}}
      					{{ Form::file('archivo_2', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file2','onchange'=>'nameFile(this.id)']) }}
	      			</div>
      				<div class="col-sm-4 pull-right input-file3">
	  					@if(!empty($medidas[0]->archivo_3))
	  						<div class="float_items">
			  					<a href="{{asset('files/certificates/'.$medidas[0]->archivo_3)}}" title="ver" target="_blank"><i class="icon-eye text-merge"></i></a>
				        		<a href="{!! url('certificado/'.$medidas[0]->id.'/archivo_3') !!}" title="eliminar"><i class="icon-trash text-danger"></i></a>
			  					{{ Form::hidden('archivo_old_3', $medidas[0]->archivo_3 )}}
	  						</div>
	  						<label for="file3" id="input-file3"> <i class="fa fa-paperclip"></i>{{ $medidas[0]->archivo_3 }}</label>
	  					@else
      						<label for="file3" id="input-file3"> <i class="fa fa-paperclip"></i>Imagen de crokis de la planta</label>
		  				@endif
      					{{-- Form::label('file3',' ') --}}
      					{{ Form::file('archivo_3', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-light fix-1','id'=>'file3','onchange'=>'nameFile(this.id)']) }}
			        </div>
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
			<form method="POST" action="{{ url('values', $val->id) }}" id="FormUpdate" enctype="multipart/form-data">
		    	{{ csrf_field() }}
		    	{{ Form::hidden('iduser', $usuario) }}
		    	{{ Form::hidden('idbranch', $sucursal) }}
		    	{{ Form::hidden('type', 'pat') }}
		        {{ Form::hidden('_method', 'PUT') }}
		        {{ Form::hidden('id', $val->id) }}
		        {{ Form::hidden('date', $val->date) }}
			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
			        <div class="white-box">
			        	<div style="background-image: url('{{ asset('images/catalog/'.$val->image_1) }}')!important; background-size:cover;">
			        		{{ Form::file('image_1',['class'=>'dropify','id'=>'input-file-now-custom-2','data-height'=>'300']) }}
			        		{{ Form::hidden('image_1_old', $val->image_1)}}
			        	</div>
				    </div>	
			    </div>

			    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">        
			        <div class="white-box">
			            <h3 class="box-title">Detalle medición</h3>
			            <hr>
			            <div>
				            <table class="table table-border-none">
				            	<tbody>
				            		<tr>
				            			<td class="col-xs-6 col-md-2"><b>Detalle</b></td>
				            			<td class="col-xs-6 col-md-10">
				            				{{ Form::text('detalles', $val->details, ['class'=>'form-control', 'required' => 'required'])}}
				            			</td>
				            		</tr>
				            		<tr>
				            			<td class="col-xs-6 col-md-2"><b>Sector</b></td>
				            			<td class="col-xs-6 col-md-10">
				            				{{ Form::text('sector', $val->sector, ['class'=>'form-control', 'required' => 'required'])}}
				            			</td>
				            		</tr>
				            		<tr>
				            			<td class="col-xs-6 col-md-2"><b>Valor</b></td>
				            			<td class="col-xs-6 col-md-10">
				            				{{ Form::text('value', $val->value, ['class'=>'form-control','id'=>'v_value'.$x,'onchange'=>'verify_value(this.id,this.value);return false;','step'=>'.01', 'required' => 'required'])}}
				            			</td>
				            		</tr>
				            		<tr>
				            			<td class="col-xs-6 col-md-2"><b>Valor máximo admisible</b></td>
				            			<td class="col-xs-6 col-md-10">
				            				{{ Form::number('value_max', $val->value_max, ['class'=>'form-control','readonly'=>'true','step'=>'.01', 'required' => 'required']) }}
				            			</td>
				            		</tr>
				            		<tr>
				            			<td class="col-xs-6 col-md-2"><b>Observación</b></td>
				            			<td class="col-xs-6 col-md-10">
			            					<?php 
			            						if(strpos($val->observation,'[')!==false){
				            						$string=false;
				            						foreach(json_decode($val->observation, true) as $obs){
				            							$string .= "- &nbsp;".$obs."\n";
				            						}
			            						}else{
			            							$string=json_decode($val->observation);
			            						}
			            					?>
				            				<textarea name="observation" class="form-control" id="piezas_v_value{{$x}}" rows="5">{{ $string }}</textarea>
				            			</td>
				            		</tr>
				            		<tr>
				            			<td class="col-xs-6 col-md-2"><b>Recomendación</b></td>
				            			<td class="col-xs-6 col-md-10">
				            				<?php 
				            					if(strpos($val->recommendation,'[')!==false){			            						
				            						$string='';
				            						foreach(json_decode($val->recommendation, true) as $obs){
				            							$string .= "- &nbsp;".$obs."\n";
				            						}
				            					}else{
				            						$string=json_decode($val->recommendation);
				            					}
			            					?>
			            					<div class="form-group" id="piezas2_v_value{{$x}}" class="form-control" style="overflow: auto; width: 100%; height: 100px; margin-bottom: 40px; border: 1px solid #e4e7ea; color:#999; padding: 5px">
			            						<textarea name="recomendation" class="form-control" style="border:none;" rows="5">{{ $string }}</textarea>
			            					</div>
			            					<div class="form-group">
			            						{{ Form::textarea('other', $val->other, ['class'=>'form-control', 'rows'=>'5']) }}
			            					</div>
				            			</td>
				            		</tr>
				            	</tbody>
				            </table>
				        </div>
			            <div class="col-sm-12 text-right">
				            {{ Form::submit('Guardar cambios', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-green']) }}
				        </div>
					</div>
			    </div>
		        {{ Form::close() }}
	            <div class="pull-right" style="bottom:28px;position:absolute;right:260px;">
	              	<form method="POST" action="{{ url('values', $val->id) }}" id="FormDelete">
	                {{ csrf_field() }}
	                {{ Form::hidden('_method', 'DELETE') }}
	                {{ Form::hidden('id', $val->id) }}
	                {{ Form::submit('Eliminar',['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-delete']) }}
	                {{ Form::close() }}
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
		            				{{ Form::text('value', null, ['class'=>'form-control','id'=>'v_value0', 'onchange'=>'verify_value(this.id,this.value);return false;','step'=>'.01', 'required' => 'required']) }}
		            			</td>
		            		</tr>
		            		<tr>
		            			<td><b>Valor máximo admisible</b></td>
		            			<td class="col-md-10">
		            				{{ Form::number('value_max', $rangos[0]->value_max, ['class'=>'form-control','readonly'=>'true','id'=>'v_max','step'=>'.01', 'required' => 'required']) }}
		            			</td>
		            		</tr>
		            		<tr>
		            			<td>
		            				<b>Observación</b>
		            			</td>
		            			<td class="col-md-10">
					                {{ Form::textarea('observation', null, ['class'=>'form-control','rows'=>'3','id'=>'piezas_v_value0']) }}
		            			</td>
		            		</tr>
		            		<tr>
		            			<td>
		            				<b>Recomendación</b>
		            			</td>
		            			<td class="col-md-10">
		            				<div id="piezas2_v_value0" class="form-control" style="overflow: auto; width: 100%; height: 100px; border: 1px solid #e4e7ea; color:#999; padding-left: 5px">
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
    </div>
    <a href="javascript:void(0);" id="newBtn" onclick="openForm();" class="btn btn-default btn-custom-tmm btn-custom-tmm-active" @if (!session('status')) @else style="display: none;" @endif >Nueva medición</a>
@endsection 

@section('javascript')
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript">
		function verify_value(id, val){
			
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
	                    $("#piezas_"+id).html(chtml);

                        var dhtml="";
                        for (datas in data.datos) {
                          dhtml+= data.datos[datas]+'<br>';
                        };
	                    $("#piezas2_"+id).html(dhtml);

	                    document.getElementById("guard_value").disabled = false; 
	                    document.getElementById("nuevo").disabled = false; 
	                }
			    });
		}

		function openForm(){
	      document.getElementById('newBtn').style.display = 'none';
	      document.getElementById('openForm').style.display = 'block';
	    }

	    function ocultar(){
	      document.getElementById('openForm').style.display = 'none';
	      document.getElementById('newBtn').style.display = 'inline-block';
	      document.getElementById("piezas_v_value0").value = "";
	      document.getElementById("piezas2_v_value0").value = "";
	      var chtml="";
	      $("#piezas_v_value0").html(chtml);
	      var dhtml="";
	      $("#piezas2_v_value0").html(dhtml);
	      document.getElementById("form_medidas").reset();
	    }

	    function nameFile(id){
			document.getElementById('input-'+id).innerHTML = document.getElementById(id).files[0].name;
		}
	</script>
@stop
