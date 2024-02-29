@extends('layouts.app')

@section('title-section','EDITAR MEDICION DE DIREFENCIALES')

@section('breadcrumbs')
    <ol class="breadcrumb">
    <li><a href="{{ url('usuarios/todos') }}">usuarios</a></li>
    <li><a href="{{ url('usuarios/'.$user->id.'/ver') }}">{{ $user->name}}</a></li>
    <li><a href="{{ url('usuarios/'.$user->id.'/sucursal/'.$branch->id) }}">{{ $branch->name}}</a></li>
    <li class="active">Editar</li>
  </ol>
@endsection

@section('content')
	<form method="POST" action="{{ url('measurement/update', $medidas[0]->id) }}" class="form" id="FormUpdate" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ Form::hidden('iduser', $usuario) }}
        {{ Form::hidden('idbranch', $sucursal) }}
        {{ Form::hidden('type', 'diferencial') }}
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::hidden('id', $medidas[0]->id) }}
        {{ Form::hidden('sector', null, ['class'=>'form-control']) }}
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
	        			<td>{{ Form::text('place',$medidas[0]->place, ['class' => 'form-control','readonly'=>'true', 'required' => 'required']) }}</td>
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
	          	<div class="col-xs-12 col-sm-12  buttons col-md-12 col-lg-9 text-xs-center text-sm-center text-md-center text-lg-right">
	      			<div class="col-sm-4 pull-right input-file1">
  						@if(!empty($medidas[0]->archivo_1))
  							<div class="float_items">
			          			<a href="{{asset('files/certificates/'.$medidas[0]->archivo_1)}}" title="ver" target="_blank"><i class="icon-eye text-merge"></i></a>
				        		<a href="{!! url('certificado/'.$medidas[0]->id.'/archivo_1') !!}" title="eliminar"><i class="icon-trash text-danger"></i></a>
			      				{{ Form::hidden('archivo_old_1', $medidas[0]->archivo_1 )}}
  							</div>
  							<label for="file1" id="input-file1"><i class="fa fa-paperclip"></i>{{ $medidas[0]->archivo_1 }}</label>
  						@else
						  	<label for="file1" id="input-file1"><i class="fa fa-paperclip"></i>Protocolo SRT 900/2015</label>
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
	    		
	    	<form method="POST" action="{{ url('values', $val->id) }}" class="form row" id="FormUpdate" enctype="multipart/form-data">
		    	{{ csrf_field() }}
		    	{{ Form::hidden('iduser', $usuario) }}
		    	{{ Form::hidden('idbranch', $sucursal) }}
		    	{{ Form::hidden('type', 'diferencial') }}
	            {{ Form::hidden('_method', 'PUT') }}
	            {{ Form::hidden('id', $val->id) }}
	            {{ Form::hidden('date', $val->date) }}
	            {{ Form::hidden('value_max', $val->value_max) }}
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
			            <h3 class="box-title">Descripción de los puntos medidos</h3>
			            <hr>
			            <table>
			            	<tr>
			            		<td class="width-min-tmm">Detalle</td>
			            		<td class="width-med-tmm">{{ Form::text('detalles', $val->details, ['class'=>'form-control', 'required' => 'required']) }}</td>
			            		<td class="width-min-tmm"></td>
			            		<td class="width-min-tmm">Sector</td>
			            		<td class="width-med-tmm">{{ Form::text('sector', $val->sector, ['class'=>'form-control', 'required' => 'required']) }}</td>
			            	</tr>
			            </table>
			            <hr>
			            <div style="min-height:400px;">
				            <table class="table table-border-none" id="table-update-{{ $x }}">
				            	<tbody>
				            		<?php $i=1; ?>
				            		@foreach(json_decode($val->value, true) as $v)
					            		<tr>
					            			<td class="width-min-tmm">Diferencial {{ $i }}</td>
					            			<td class="width-min-tmm">
					            				<input type="text" name="cant[]" id="c#{{ $x.$i }}" class="form-control borded-success" 
												value="{{ (isset($v[3]) && !is_null($v[3])) ? $v[3]  : $v[0] }}" onchange="verifyValue(this.value, this.id);" onKeyUp="javascript:this.value = this.value.replace(/,/,'.');" required>
												<input type="hidden" name="equiv[]" id="e#{{ $x.$i }}">
					            			</td>
					            			<td class="width-min-tmm">Observación</td>
					            			<td class="width-max-tmm"><input type="text" name="desc[]" id="d#{{ $x.$i }}" class="form-control" value="{{ $v[1] }}"></td>
					            			<td class="width-min-tmm"><i class="icon-trash" onClick="borrarValor(this)"></i><input type="hidden" name="icono[]" id="i#{{ $x.$i }}" value="{{$v[2]}}"><div id="f#{{ $x.$i }}" class="{{$v[2]}}"></div></td>
					            		</tr>
					            		<?php $i++; ?>
				            		@endforeach
				            	</tbody>
				            </table>
				            <div class="row">
				            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
				            		<button id="btnaddup" onclick="newUpdateItem('table-update-{{ $x }}','{{ $x }}')" class="btn btn-default btn-custom-tmm btn-custom-tmm-light">Agregar Punto</button>
				            	</div>
				            </div>
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
	    <?php $x++; ?>
    @endforeach

    <div id="openForm" @if (session('status')) @else style="display: none;" @endif >
	    {{ Form::open(['url'=>'values/store','method'=>'post','class'=>'form','id'=>'form_medidas','name'=>'form_medidas','enctype'=>'multipart/form-data']) }}
	        {{ Form::hidden('iduser', $usuario) }}
	        {{ Form::hidden('idbranch', $sucursal) }}
	        {{ Form::hidden('idmeasurement', $medidas[0]->id) }}
	        {{ Form::hidden('type', $medidas[0]->type) }}
	        {{ Form::hidden('value_max', $rangos[0]->value_max, ['class'=>'form-control','id'=>'v_max']) }}
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
			            <h3 class="box-title">Tablero y diferenciales</h3>
			            <hr>
			            <table>
			            	<tr>
			            		<td class="width-min-tmm">Detalle</td>
			            		<td class="width-med-tmm">{{ Form::text('detalles', null, ['class'=>'form-control', 'required' => 'required']) }}</td>
			            		<td class="width-min-tmm"></td>
			            		<td class="width-min-tmm">Sector</td>
			            		<td class="width-med-tmm">{{ Form::text('sector', null, ['class'=>'form-control', 'required' => 'required']) }}</td>
			            	</tr>
			            </table>
			            <hr>
			            <table>
			            	<tr></tr>
		            		<tr>
		            			<td class="width-med-tmm">Cuántos valores desea agregar?</td>
		            			<td class="width-mas-tmm"><input type="number" id="input_cant" name="input_cant" max="99" min="0" class="form-control" value="1"></td>
		            			<td class="width-mas-tmm"><a id="btn_input_add" onClick="newItem()" class="btn btn-default btn-custom-tmm btn-custom-tmm-muted text-white">Agregar </i></a></td>
		            			<td class="width-mas-tmm"><a id="btn_input_add" onClick="newItemGood();" class="btn btn-default btn-custom-tmm btn-custom-tmm-green text-white">Agregar <i class="fa fa-check-circle-o"></i></a></td>
		            		</tr>
			            </table>
			            <hr>
			            <table id="tblprod" class="table table-responsive table-border-none style-table-abm">
			            	<tbody>
			            		<tr>
			            			<td class="width-min-tmm">Diferencial 1</td>
			            			<td class="width-min-tmm">
			            				<input type="text" name="cant[]" id="c#0" class="form-control borded-success" onchange="verifyValue(this.value, this.id);"  onKeyUp="javascript:this.value = this.value.replace(/,/,'.');" required>
			            				<input type="hidden" name="equiv[]" id="e#0">
			            			</td>
			            			<td class="width-min-tmm">Observación</td>
			            			<td class="width-max-tmm"><input type="text" name="desc[]" id="d#0" class="form-control"></td>
			            			<td class="width-min-tmm"><i class="icon-trash" onClick="borrarValor(this)"></i><input type="hidden" name="icono[]" id="i#0"><div id="f#0"></div></td>
			            		</tr>
			            	</tbody>
			            </table>
			            <div class="row">
			            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			            		<button id="btnadd" class="btn btn-default btn-custom-tmm btn-custom-tmm-light">Agregar diferencial</button>
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
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(function() {
		   $(document).on("click","#btnadd",function( event ) {  
		    var tr=document.getElementById("tblprod").rows.length;		
			var count = tr;
			var ultimaFila = $('#tblprod tr:last');
			if (ultimaFila.length !== 0) {
	  			$('#tblprod tr:last').after('<tr><td class="width-min-tmm">Diferencial '+ count +'</td><td class="width-min-tmm"><input type="text" name="cant[]" id="c#'+count+'" class="form-control borded-success" onchange="verifyValue(this.value, this.id);"  onKeyUp="javascript:this.value = this.value.replace(/,/,\'.\');" required><input type="hidden" name="equiv[]" id="e#'+count+'"></td><td class="width-min-tmm">Observacion</td><td class="width-max-tmm"><input type="text" name="desc[]" id="d#'+count+'"  class="form-control"></td><td class="width-min-tmm"><i class="icon-trash" onClick="borrarValor(this)"></i><input type="hidden" name="icono[]" id="i#'+count+'"><div id="f#'+count+'"></div></td></tr>');
	  		}
			count++;
	      	event.preventDefault();
	   		tr = document.getElementById("tblprod").rows.length;
		   });
		});

		function newItem(){ 
			var tr=document.getElementById("tblprod").rows.length;
		    var cant = document.getElementById('input_cant').value;
		    // var index = tr+1;
			var index = 1;
			$('#tblprod tbody').html('<tr></tr>');
		  	for (var i = cant - 1; i >= 0; i--) {

				// Modificado por Mendo el 16/02 para habilitar la funcionalidad de borrar items

				var ultimaFila = $('#tblprod tr:last');
				if (ultimaFila.length !== 0) {
					$('#tblprod tr:last').after('<tr><td class="width-min-tmm">Diferencial '+ index +'</td><td class="width-min-tmm"><input type="text" name="cant[]" id="c#'+index+'" class="form-control borded-success" onchange="verifyValue(this.value, this.id);"  onKeyUp="javascript:this.value = this.value.replace(/,/,\'.\');" required><input type="hidden" name="equiv[]" id="e#'+index+'"></td><td class="width-min-tmm">Observacion</td><td class="width-max-tmm"><input type="text" name="desc[]" id="d#'+index+'"  class="form-control"></td><td class="width-min-tmm"><i class="icon-trash" onClick="borrarValor(this)"></i><input type="hidden" name="icono[]" id="i#'+index+'"><div id="f#'+index+'"></div></td></tr>');
				}
				event.preventDefault();
				index++;
				tr=document.getElementById("tblprod").rows.length;
			}
		}

		function newItemGood(){
			var tr=document.getElementById("tblprod").rows.length;
		    var cant = document.getElementById('input_cant').value;
		    // var index = tr + 1;
			var index = 1;
		    var data = '<?php if(!empty($rangos_valores)) echo $rangos_valores; ?>';
		    if(data == '[]'){
		    	alert('Para utilizar esa función, primero debe cargar los valores de rangos de continuidad.');
		    	return
		    }
	        var content = JSON.parse(data);
	        var ban = false;
			$('#tblprod tbody').html('<tr></tr>');
	        for (var i = cant - 1; i >= 0; i--) {
        		var rand = numeroAleatorio(content[0].since, content[0].until);

        		var ultimaFila = $('#tblprod tr:last');
				if (ultimaFila.length !== 0) {
					$('#tblprod tr:last').after('<tr><td class="width-min-tmm">Diferencial '+ index +'</td><td class="width-min-tmm"><input type="text" name="cant[]" id="c#'+index+'" class="form-control borded-success" onchange="verifyValue(this.value, this.id);"  onKeyUp="javascript:this.value = this.value.replace(/,/,\'.\');" value="'+rand+'" required><input type="hidden" name="equiv[]" id="e#'+index+'"></td><td class="width-min-tmm">Observacion</td><td class="width-max-tmm"><input type="text" name="desc[]" id="d#'+index+'" class="form-control" value="'+content[0].observation+'"></td><td class="width-min-tmm"><i class="icon-trash" onClick="borrarValor(this)"></i><input type="hidden" name="icono[]" id="i#'+index+'" value="'+content[0].icono+'"><div id="f#'+index+'" class="'+content[0].icono+'"></div></td></tr>');
				}
				index++;
				tr=document.getElementById("tblprod").rows.length;
	        }
		}

		function newUpdateItem(id, x){ 
			var tr=document.getElementById(id).rows.length;
		    var count = tr + 1;

			var ultimaFila = $('#'+id+' tr:last');
			if (ultimaFila.length !== 0) {
				$('#'+id+' tr:last').after('<tr><td class="width-min-tmm">Diferencial '+ count +'</td><td class="width-min-tmm"><input type="text" name="cant[]" id="c#'+count+''+ x +'" class="form-control borded-success" onchange="verifyValue(this.value, this.id);" onKeyUp="javascript:this.value = this.value.replace(/,/,\'.\');" required><input type="hidden" name="equiv[]" id="e#'+count+''+x+'"></td><td class="width-min-tmm">Observacion</td><td class="width-max-tmm"><input type="text" name="desc[]" id="d#'+count+''+ x +'"  class="form-control"></td><td class="width-min-tmm"><i class="icon-trash" onClick="borrarValor(this)"></i><input type="hidden" name="icono[]" id="i#'+count+''+ x +'"><div id="f#'+count+''+ x +'"></div></td></tr>');
			}
			count++;
			event.preventDefault();
			tr = document.getElementById(id).rows.length;
		}

		function numeroAleatorio(min, max) {
			var numero =  Math.random() * (max - min) + min;
			// var numero = parseFloat(numero);
			// var conDecimal = numero.toFixed(2);
			var numero = parseInt(numero);
			return numero;
		}

		function verifyValue(val,id){
			// Verifica los niveles de diferenciales en los puntos
			// Y los compoara con los rangos preestablecidos
			// Ademas verifica que no se pase del maximo permitido
			var max = document.getElementById("v_max").value;
			var res = id.split("#");
			var data = '<?php if(!empty($rangos_valores)) echo $rangos_valores; ?>';
			var equiv = '<?php echo $equivalences; ?>';
	        var content = JSON.parse(data);
			var equivalence = JSON.parse(equiv);
	        var ban = false;

			if(data == '[]'){
		    	alert('Primero debe cargar los valores de rangos de diferencial.');
		    	document.getElementById("guard_value").disabled = true;
		    	document.getElementById("nuevo").disabled = true;
		    	return
		    }
		    if(isNaN(val)){
		    	//Valor alfanumerico de diferenciales
		    	for (var i = 0; i < equivalence.length; i++){
		    		if(val == equivalence[i].code){
		    			for (var z = content.length - 1; z >= 0; z--) {
				        	var min = parseFloat(content[z].since);
				        	var max = parseFloat(content[z].until);
				        	if(parseFloat(equivalence[i].value) >=  min && parseFloat(equivalence[i].value) <= max) {
				        		document.getElementById("d#"+res[1]).value = equivalence[i].observation;
				        		document.getElementById("e#"+res[1]).value = equivalence[i].value;
				        		document.getElementById("i#"+res[1]).value = content[z].icono;
				        		document.getElementById("f#"+res[1]).className = content[z].icono;
				        		ban=true;
				        	}
				        };
		    		}
		    	}
		    	if(ban == false){
		    		alert('Valor de Equivalencia no encontrado.');
		    	}
		    }else{
		    	//Valor numerico de diferenciales
				if(parseInt(val) < parseInt(max)){
					document.getElementById("guard_value").disabled = false; 
					document.getElementById("nuevo").disabled = false;
				}
		        for (var i = content.length - 1; i >= 0; i--) {
		        	var min = parseInt(content[i].since);
		        	var max = parseInt(content[i].until);
		        	if(parseInt(val) >=  min && parseInt(val) <= max) {
		        		document.getElementById("d#"+res[1]).value = content[i].observation;
		        		document.getElementById("i#"+res[1]).value = content[i].icono;
		        		document.getElementById("e#"+res[1]).value = '';
		        		document.getElementById("f#"+res[1]).className = content[i].icono;
		        		ban=true;
		        	}
		        };
		        if(ban==false){
		        	document.getElementById("i#"+res[1]).className = '';
		        	document.getElementById("d#"+res[1]).value = 'Valor Severo';
		        	document.getElementById("e#"+res[1]).value = '';
		        	document.getElementById("i#"+res[1]).value = 'RANGO_3';
		        	document.getElementById("f#"+res[1]).className = 'RANGO_3';
		        }
		    }
		}

		function borrarValor(el) {
			var tr = $('#tblprod tr');
			const fila = el.parentElement.parentElement;
			fila.parentElement.removeChild(fila);
		}

		function openForm(){
	      document.getElementById('newBtn').style.display = 'none';
	      document.getElementById('openForm').style.display = 'block';
	    }

	    function ocultar(){
	      	document.getElementById('openForm').style.display = 'none';
	      	document.getElementById('newBtn').style.display = 'inline-block';
	      	var list = document.getElementById("tblprod");
		    while (list.hasChildNodes()) {
		        list.removeChild(list.firstChild);
		    }
		    $('#tblprod').html('<tbody><tr></tr></tbody>');
	      	document.getElementById("form_medidas").reset();
	    }

	    function nameFile(id){
			document.getElementById('input-'+id).innerHTML = document.getElementById(id).files[0].name;
		}
	</script>
@stop