@extends('layouts.app')

@section('title-section','SUCURSAL')

@section('breadcrumbs')
    @if(Auth::user()->hasRole('user'))
      <ol class="breadcrumb">
        <li><a href="{{ url('users/dashboard') }}">{{ $user->name }}</a></li>
        <li class="active">{{ $branch->name }}</li>
      </ol>
    @elseif(Auth::user()->hasRole('admin'))
      <ol class="breadcrumb">
        <li><a href="{{ url('usuarios/todos') }}">usuarios</a></li>
	    <li><a href="{{ url('usuarios/'.$user->id.'/ver') }}">{{ $user->name}}</a></li>
	    <li  class="active"><a href="{{ url('usuarios/'.$user->id.'/sucursal/'.$branch->id) }}">{{ $branch->name}}</a></li>
      </ol>
    @endif
@endsection

@section('content')
	@if(Auth::user()->hasRole('user'))
		<h1 class="text-center">{{ $branch->name }} </h1>
	@elseif(Auth::user()->hasRole('admin'))
		<h1 class="text-center">{{ $user->name .' - '. $branch->name }} </h1>
	    <div class="white-box">
	        <h3 class="box-title m-b-0">GENERAR NUEVA MEDICIÓN PUESTA A TIERRA / CONTINUIDAD / DIFERENCIALES / TERMOGRAFÍA 
		        <div class="pull-right">
		        	<button type="button" class="btn btn-default btn-custom-tmm btn-custom-tmm-active" data-toggle="modal" data-target="#Modal_medicion">Nueva medición</button>
		        </div>
	        </h3>
	    </div>
	@endif

	<!-- puestas a tierras -->
	    <div class="white-box  box-title-tmm-blue">
	        <h3 class="box-title m-b-0">
	        	@foreach($contador as $contado)
			    	@if($contado->type =='pat')
			  	      <span>{{ $contado->num }}</span> 
			        @endif
		        @endforeach
	        	PUESTA A TIERRA
	        	@if(Auth::user()->hasRole('admin'))
			        <div class="pull-right">
			        	<a href="{!! route('usuarios.sucursal.nuevo', [$user->id, $branch->id,'pat']); !!}"><button class="btn btn-default btn-custom-tmm btn-custom-tmm-active">NUEVA MEDICIÓN</button></a>
			        </div>
		        @endif
	        </h3>
	    </div>
	    @foreach ($tipos as $tipo)
		    @if ($tipo->type == 'pat')
			    <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				    	<div class="white-box">
					    	<table class="table table-bordered text-center">
					    		<h3>PUESTA A TIERRA</h3>
					    		<thead>
					    			<tr>
					    				<th class="text-center width-state-tmm">Fecha de medición</th>
					    				<th class="text-center width-state-tmm">Cantidad de mediciones de PAT</th>
					    				<th class="text-center">Nivel de criticidad general (PAT)</th>
					    				<th></th>
					    			</tr>
					    		</thead>
					    		<tbody>
					    			@foreach($meas as $pat)
					    				@if($pat->type == 'pat')
							    			<tr>
							    				<td class="text-center">{{ date_format(date_create($pat->date), 'd-m-Y') }}</td>
							    				<td class="text-center">
								    				@foreach($criticidad as $crit)
								    					@if($pat->id == $crit->idmeasurements)
								    						{{ $crit->cant }}
								    					@endif
								    				@endforeach
							    				</td>
							    				<td class="text-center">
							    					@if($puestatierra != false)
								    					@foreach($puestatierra as $pt)
									            			@if($pt['id'] == $pat->id)
									                            <span>{{ number_format($pt['criterion'], 2) }}%</span>
									                            <div class="progress">
									                                <div class="progress-bar progress-bar-{{ $pt['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $pt['criterion'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $pt['criterion'] }}%;"></div>
									                            </div>
									                        @endif
								                        @endforeach
							                        @endif
					                            </td>
							    				<td class="text-center">
							    					@if(Auth::user()->hasRole('user'))
							    						{{-- Verifico que hayan valores cargados --}}
								    					@php $band = false; @endphp
								    					@foreach($criticidad as $crit)
									    					@if($pat->id == $crit->idmeasurements)
									    						<a href="{!! route('sucursal.show', [$branch->id,'pat', $pat->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
									    						@php $band = true; @endphp
									    					@endif
									    				@endforeach
								    					@if ($criticidad == '[]' || $band == false)
								    						<a href="javascript:void(0)" class="fa-link-tmm text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
								    					@endif
							    					@elseif(Auth::user()->hasRole('admin'))
								    					{{-- Verifico que hayan valores cargados --}}
								    					@php $band = false; @endphp
								    					@foreach($criticidad as $crit)
									    					@if($pat->id == $crit->idmeasurements)
									    						<a href="{!! route('usuario.sucursal.show', [$user->id, $branch->id,'pat', $pat->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
									    						@php $band = true; @endphp
									    					@endif
									    				@endforeach
								    					@if ($criticidad == '[]' || $band == false)
								    						<a href="javascript:void(0)" class="fa-link-tmm text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
								    					@endif
								    					<a href="{!! route('measurement/duplicate', [$pat->id]) !!}" onclick = "if(confirm('Seguro desea duplicar la medida?')) { return true; }" class="fa-link-tmm text-info"><i class="fa fa-copy"></i></a>
								    					<a href="{!! route('usuarios.sucursal.edit', [$user->id, $branch->id,'pat', $pat->id]); !!}" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a>
								    					<a href="{!! route('measurement.delete', [$pat->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
							    					@endif
							    				</td>
							    			</tr>
					    				@endif
					    			@endforeach
					    		</tbody>
					    	</table>
					    </div>
				    </div>
				</div>
			@endif
		@endforeach

	<!-- Continuidades -->
	    <div class="white-box box-title-tmm-muted">
	        <h3 class="box-title m-b-0">
	        	@foreach($contador as $contado)
			    	@if($contado->type =='continuidad')
			  	      <span>{{ $contado->num }}</span> 
			        @endif
		        @endforeach
	        	CONTINUIDAD
	        	@if(Auth::user()->hasRole('admin'))
			        <div class="pull-right">
			        	<a href="{!! route('usuarios.sucursal.nuevo', [$user->id, $branch->id,'continuidad']); !!}"><button class="btn btn-default btn-custom-tmm btn-custom-tmm-active">NUEVA MEDICIÓN</button></a>
			        </div>
		        @endif
	        </h3>
	    </div>
	    @foreach ($tipos as $tipo)
		    @if ($tipo->type == 'continuidad')
			    <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				    	<div class="white-box">
					    	<table class="table table-bordered text-center">
					    		<h3>CONTINUIDAD</h3>
					    		<thead>
					    			<tr>
					    				<th class="text-center width-state-tmm">Fecha de medición</th>
					    				<th class="text-center width-state-tmm">Cantidad de mediciones de continuidad</th>
					    				<th class="text-center">Nivel de criticidad general</th>
					    				<th></th>
					    			</tr>
					    		</thead>
					    		<tbody>
					    			@foreach($meas as $continuity)
					    				@if($continuity->type == 'continuidad')
							    			<tr>
							    				<td class="text-center">{{ date_format(date_create($continuity->date), 'd-m-Y') }}</td>
							    				<td class="text-center">
							    					@foreach($criticidad as $crit)
								    					@if($continuity->id == $crit->idmeasurements)
								    						{{ $c = $crit->cant }}
								    					@endif
								    				@endforeach
							    				</td>
							    				<td class="text-center">
							    					@foreach($criticidadCyD as $cyd)
						                            @if($cyd['id'] == $continuity->id)
						                                  <span>{{ number_format($cyd['criticidad'], 2) }}%</span>
						                                  <div class="progress">
						                                      <div class="progress-bar progress-bar-{{ $cyd['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $cyd['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $cyd['criticidad'] }}%;"></div>
						                                  </div>
						                              @endif
						                            @endforeach
					                            </td>
							    				<td class="text-center">
							    					@if(Auth::user()->hasRole('user'))
							    						{{-- Verifico que hayan valores cargados --}}
								    					@php $band = false; @endphp
								    					@foreach($criticidad as $crit)
									    					@if($continuity->id == $crit->idmeasurements)
									    						<a href="{!! route('sucursal.show', [$branch->id,'continuidad', $continuity->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
									    						@php $band = true; @endphp
									    					@endif
									    				@endforeach
								    					@if ($criticidad == '[]' || $band == false)
								    						<a href="javascript:void(0)" class="fa-link-tmm  text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
								    					@endif
							    					@elseif(Auth::user()->hasRole('admin'))
								    					{{-- Verifico que hayan valores cargados --}}
								    					@php $band = false; @endphp
								    					@foreach($criticidad as $crit)
									    					@if($continuity->id == $crit->idmeasurements)
									    						<a href="{!! route('usuario.sucursal.show', [$user->id, $branch->id,'continuidad', $continuity->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
									    						@php $band = true; @endphp
									    					@endif
									    				@endforeach
								    					@if ($criticidad == '[]' || $band == false)
								    						<a href="javascript:void(0)" class="fa-link-tmm  text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
								    					@endif
								    					<a href="{!! route('measurement/duplicate', [$continuity->id]) !!}" onclick = "if(confirm('Seguro desea duplicar la medida?')) { return true; }" class="fa-link-tmm text-info"><i class="fa fa-copy"></i></a>
								    					<a href="{!! route('usuarios.sucursal.edit', [$user->id, $branch->id,'continuidad', $continuity->id]); !!}" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a>
								    					<a href="{!! route('measurement.delete', [$continuity->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
							    					@endif
							    				</td>
							    			</tr>
							    		@endif
						    		@endforeach
					    		</tbody>
					    	</table>
					    </div>
				    </div>
				</div>
			@endif
		@endforeach

	<!-- Diferenciales -->
	    <div class="white-box box-title-tmm-grey">
	        <h3 class="box-title m-b-0">
	        	 @foreach($contador as $contado)
			    	@if($contado->type =='diferencial')
			  	      <span>{{ $contado->num }}</span> 
			        @endif
		        @endforeach
	        	DIFERENCIALES
	        	@if(Auth::user()->hasRole('admin'))
			        <div class="pull-right">
			        	<a href="{!! route('usuarios.sucursal.nuevo', [$user->id, $branch->id,'diferencial']); !!}"><button class="btn btn-default btn-custom-tmm btn-custom-tmm-active">NUEVA MEDICIÓN</button></a>
			        </div>
		        @endif
	        </h3>
	    </div>
	    @foreach ($tipos as $tipo)
		    @if ($tipo->type == 'diferencial')
			    <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				    	<div class="white-box">
					    	<table class="table table-bordered text-center">
					    		<h3>DIFERENCIALES</h3>
					    		<thead>
					    			<tr>
					    				<th class="text-center width-state-tmm">Fecha de análisis</th>
					    				<th class="text-center width-state-tmm">Cantidad de diferenciales</th>
					    				<th class="text-center">Nivel de criticidad general</th>
					    				<th></th>
					    			</tr>
					    		</thead>
					    		<tbody>
					    			@foreach($meas as $differential)
					    				@if($differential->type == 'diferencial')
							    			<tr>
							    				<td class="text-center">{{ date_format(date_create($differential->date), 'd-m-Y') }}</td>
							    				<td class="text-center">
							    					@foreach($criticidad as $crit)
								    					@if($differential->id == $crit->idmeasurements)
								    						{{ $c = $crit->cant }}
								    					@endif
								    				@endforeach
							    				</td>
							    				<td class="text-center">
							    					@foreach($criticidadCyD as $cyd)
						                            	@if($cyd['id'] == $differential->id)
						                                  <span>{{ number_format($cyd['criticidad'], 2) }}%</span>
						                                  <div class="progress">
						                                      <div class="progress-bar progress-bar-{{ $cyd['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $cyd['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $cyd['criticidad'] }}%;"></div>
						                                  </div>
						                              @endif
						                            @endforeach
					                            </td>
							    				<td class="text-center">
							    					@if(Auth::user()->hasRole('user'))
							    						{{-- Verifico que hayan valores cargados --}}
								    					@php $band = false; @endphp
								    					@foreach($criticidad as $crit)
									    					@if($differential->id == $crit->idmeasurements)
									    						<a href="{!! route('sucursal.show', [$branch->id,'diferencial', $differential->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
									    						@php $band = true; @endphp
									    					@endif
									    				@endforeach
								    					@if ($criticidad == '[]' || $band == false)
								    						<a href="javascript:void(0)" class="fa-link-tmm  text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
								    					@endif
							    					@elseif(Auth::user()->hasRole('admin'))
								    					{{-- Verifico que hayan valores cargados --}}
								    					@php $band = false; @endphp
								    					@foreach($criticidad as $crit)
									    					@if($differential->id == $crit->idmeasurements)
									    						<a href="{!! route('usuario.sucursal.show', [$user->id, $branch->id,'diferencial', $differential->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
									    						@php $band = true; @endphp
									    					@endif
									    				@endforeach
								    					@if ($criticidad == '[]' || $band == false)
								    						<a href="javascript:void(0)" class="fa-link-tmm  text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
								    					@endif
								    					<a href="{!! route('measurement/duplicate', [$differential->id]) !!}" onclick = "if(confirm('Seguro desea duplicar la medida?')) { return true; }" class="fa-link-tmm text-info"><i class="fa fa-copy"></i></a>
								    					<a href="{!! route('usuarios.sucursal.edit', [$user->id, $branch->id,'diferencial', $differential->id]); !!}" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a>
								    					<a href="{!! route('measurement.delete', [$differential->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
							    					@endif
							    				</td>
							    			</tr>
					    				@endif
					    			@endforeach
					    		</tbody>
					    	</table>
					    </div>
				    </div>
				</div>
			@endif
		@endforeach

	<!-- Termografias -->
	    <div class="white-box  box-title-tmm-merge">
	        <h3 class="box-title m-b-0">
		    	@foreach($contador as $contado)
			    	@if($contado->type =='termografia')
			  	      <span>{{ $contado->num }}</span> 
			        @endif
		        @endforeach
	        	TERMOGRAFÍAS
	        	@if(Auth::user()->hasRole('admin'))
			        <div class="pull-right">
			        	<a href="{!! route('usuarios.sucursal.nuevo', [$user->id, $branch->id,'termografia']); !!}"><button class="btn btn-default btn-custom-tmm btn-custom-tmm-active">NUEVA MEDICIÓN</button></a>
			        </div>
	        	@endif
	        </h3>
	    </div>
	    @foreach ($tipos as $tipo)
	   	    @if ($tipo->type == 'termografia')
			    <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				    	<div class="white-box">
					    	<table class="table table-bordered text-center">
					    		<h3>TERMOGRAFÍAS</h3>
					    		<thead>
					    			<tr>
					    				<th class="text-center width-state-tmm">Fecha de realización</th>
					    				<th class="text-center width-state-tmm">Cantidad de imágenes</th>
					    				<th class="text-center">Nivel de criticidad general</th>
					    				<th></th>
					    			</tr>
					    		</thead>
					    		<tbody>
					    			@foreach ($meas as $thermography)
					    				@if($thermography->type == 'termografia')
					    				<tr>
						    				<td class="text-center">{{ date_format(date_create($thermography->date), 'd-m-Y') }}</td>
						    				<td class="text-center">
						    					@foreach($criticidad as $crit)
							    					@if($thermography->id == $crit->idmeasurements)
							    						{{ $crit->cant_t }}
							    					@endif
							    				@endforeach
						    				</td>
						    				<td class="text-center">
						    					@foreach($termografia as $t)
							            			@if($t['id'] == $thermography->id)
							                            <span>{{ number_format($t['criterion'],2) }}%</span>
							                            <div class="progress">
							                                <div class="progress-bar progress-bar-{{ $t['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $t['criterion'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $t['criterion'] }}%;"></div>
							                            </div>
							                        @endif
						                        @endforeach
				                            </td>
						    				<td class="text-center">
						    					@if(Auth::user()->hasRole('user'))
						    						{{-- verifico que hayan valores cargados --}}
							    					@php $band = false; @endphp
							    					@foreach($criticidad as $crit)
								    					@if($thermography->id == $crit->idmeasurements)
								    						<a href="{!! route('sucursal.show', [$branch->id,'termografia', $thermography->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
								    						@php $band = true; @endphp
								    					@endif
								    				@endforeach
							    					@if ($criticidad == '[]' || $band == false)
							    						<a href="javascript:void(0)" class="fa-link-tmm text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
							    					@endif
						    					@elseif(Auth::user()->hasRole('admin'))
							    					{{-- verifico que hayan valores cargados --}}
							    					@php $band = false; @endphp
							    					@foreach($criticidad as $crit)
								    					@if($thermography->id == $crit->idmeasurements)
								    						<a href="{!! route('usuario.sucursal.show', [$user->id, $branch->id,'termografia', $thermography->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
								    						@php $band = true; @endphp
								    					@endif
								    				@endforeach
							    					@if ($criticidad == '[]' || $band == false)
							    						<a href="javascript:void(0)" class="fa-link-tmm text-muted" title="La vista no esta disponible por que no existen valores cargados en la medida"><i class="icon-eye"></i></a>
							    					@endif
							    					<a href="{!! route('measurement/duplicate', [$thermography->id]) !!}" onclick = "if(confirm('Seguro desea duplicar la medida?')) { return true; }" class="fa-link-tmm text-info"><i class="fa fa-copy"></i></a>
							    					<a href="{!! route('usuarios.sucursal.edit', [$user->id, $branch->id,'termografia', $thermography->id]); !!}" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a>
							    					<a href="{!! route('measurement.delete', [$thermography->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
						    					@endif
						    				</td>
						    			</tr>
						    			@endif
					    			@endforeach
					    		</tbody>
					    	</table>
					    </div>
				    </div>
				</div>
	   	    @endif
	   	@endforeach

	<!-- Modal_medicion -->
    <div class="modal fade" id="Modal_medicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">NUEVA MEDICIÓN
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </h5>
            </div>
            <div class="modal-body">
              {{ Form::open(['url'=>'usuarios/sucursal/Medida/nuevo', 'method'=>'post', 'class'=>'form row']) }}
                {{ Form::hidden('idu', $user->id) }}
                {{ Form::hidden('sucursal', $branch->id) }}
                <div class="col-sm-12">
                  <div class="form-group">
                    {{ Form::label('Tipo de medición') }}
                    {{ Form::select('type', ['pat' => 'PAT', 'continuidad' => 'CONTINUIDAD', 'diferencial' => 'DIFERENCIALES', 'termografia' => 'TERMOGRAFÍA'], null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-sm-12 text-right">
                  <hr>
                  <div class="form-group">
                    {{ Form::reset('Descartar', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-muted',' data-dismiss'=>'modal']) }}
                    {{ Form::submit('Crear medición', ['class'=>'btn btn-default btn-custom-tmm btn-custom-tmm-active']) }}
                  </div>
                </div>
              {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Modal_medicion -->

@endsection 

@section('javascript')
@stop
