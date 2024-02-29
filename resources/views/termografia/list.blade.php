@extends('layouts.app')

@section('title-section','LISTADO DE MEDICIONES DE '.$type)

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li><a href="{{ url('usuarios/todos') }}">usuarios</a></li>
    <li><a href="{{ url('usuarios/'.$user->id.'/ver') }}">{{ $user->name}}</a></li>
    <li  class="active">{{ $type }}</li>
  </ol>
@endsection

@section('content')
	@if ($medidas != '[]')

	    <div class="row">
			<div class="col-md-6">
			    @if ($alarma != '[]')
					@php $type = false; @endphp
		        	@foreach($alarma as $a)
	                  @if($a->type == 'termografia')
	                    @php 
	                    	$count = $a->count; 
	                    	$type = true;
	                    @endphp 
	                  @endif
	                @endforeach
	                @if($type == true)
					    <div class="white-box  box-title-tmm-red">
					        <h3 class="box-title m-b-0">
				                {{ $count }} Alertas
						        <div class="pull-right">
						        	<i class="icon-bell fa-2x"></i>
						        </div>
					        </h3>
					    </div>
				    @endif
				@endif

			    <div class="white-box  box-title-tmm-muted">
			        <h3 class="box-title m-b-0">
			        	Vigencia de la medición
				        <div class="pull-right">
				        	<ul class="list-inline vigency">
				        		@php $ban = true; @endphp
				        		@foreach($vigencia as $vig)
				        			@if($ban == true)
				        				@if($vig['years'] > 0 )
				        						<li><i class="fa fa-circle fa-2x text-success vigency-trans"></i></li>
								        		<li><i class="fa fa-circle fa-2x text-warning vigency-trans"></i></li>
								        		<li><i class="fa fa-circle fa-3x text-danger"></i></li>
				        					@php $ban = false; @endphp
				        				@elseif($vig['validity']=='En fecha de renovación')
				        					<li><i class="fa fa-circle fa-2x text-success vigency-trans"></i></li>
							        		<li><i class="fa fa-circle fa-3x text-warning"></i></li>
							        		<li><i class="fa fa-circle fa-2x text-danger vigency-trans"></i></li>
							        		@php $ban = false; @endphp
				        				@endif
				        			@endif
				        		@endforeach
				        		@if($ban == true)
				        			<li><i class="fa fa-circle fa-3x text-success"></i></li>
					        		<li><i class="fa fa-circle fa-2x text-warning vigency-trans"></i></li>
					        		<li><i class="fa fa-circle fa-2x text-danger vigency-trans"></i></li>
					        		@php $ban = false; @endphp
				        		@endif
				        	</ul>
				        </div>
			        </h3>
			    </div>
			</div>
		</div>

	    <h3 class="text-uppercase">LISTADO DE TERMOGRAFÍAS</h3>

	    @foreach($sucursales as $s)

	    	@php $verificador = false; @endphp
			@foreach($medidas as $m)
				@if($s->id === $m->idbranch_office)
					@php $verificador = true; @endphp
				@endif
			@endforeach
		    <div class="row">
		    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    		<div class="white-box">
		    			<h3>{{ $s->name }}
		    				<div class="pull-right">
								<button class="btn btn btn-default btn-custom-tmm btn-custom-tmm-active" data-toggle="modal" data-target="#Modal_medicion">Nueva Medición</button>
							</div>
		    			</h3>
		    			@if($verificador == true)
			    			<table class="table table-bordered text-center">
				            	<tr> 
				            		<td class="text-center"><b>Fecha</b></td>
				            		<td class="text-center"><b>Cant de análisis</b></td>
				            		<td class="text-center"><b>Nivel de Criticidad General</b></td>
				            		<td class="text-center"></td>
				            	</tr>
				            	@foreach($medidas as $m)
				            		@if($s->id === $m->idbranch_office)
						            	<tr>
						            		<td class="text-center">{{ date_format(date_create($m->date), 'd-m-Y') }}</td>
						            		<td class="text-center">
						            			@foreach($cantidad as $c)
						            				@if($m->id ==$c->idmeasurements)
						            					{{ $c->count }}
						            				@endif
						            			@endforeach
						            		</td>
						            		<td class="text-center">
						            			@foreach($termografia as $t)
							            			@if($t['id'] == $m->id)
							                            <span>{{ number_format($t['criterion'], 2) }}%</span>
							                            <div class="progress">
							                                <div class="progress-bar progress-bar-{{ $t['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $t['criterion'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $t['criterion'] }}%;"></div>
							                            </div>
							                        @endif
						                        @endforeach
						            		</td>
						            		<td class="text-center">
						            			<a href="{!! route('usuario.sucursal.show', [$user->id, $s->id,'termografia', $m->id]); !!}" class="fa-link-tmm text-merge"><i class="icon-eye"></i></a>
						    					<a href="{!! route('measurement/duplicate', [$m->id]) !!}" onclick = "if(confirm('Seguro desea duplicar la medida?')) { return true; }" class="fa-link-tmm text-info"><i class="fa fa-copy"></i></a>
						    					<a href="{!! route('usuarios.sucursal.edit', [$user->id, $s->id, $m->type, $m->id]); !!}" class="fa-link-tmm text-muted"><i class="icon-pencil"></i></a>
						    					<a href="{!! route('measurement.delete', [$m->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
						            		</td>
						            	</tr>
				            		@endif
				            	@endforeach
					        </table>
				        @else
				        	<p class="text-uppercase mt-40">NO EXISTEN MEDICIONES DE TERMOGRAFÍA </p>
				        @endif
		    		</div>
		    	</div>
		    </div>
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
	                {{ Form::hidden('sucursal', $sucursales[0]->id) }}
	                <div class="col-sm-12">
	                  <div class="form-group">
	                    {{ Form::label('Tipo de medición') }}
	                    {{ Form::select('type', ['pat' => 'PAT', 'continuidad' => 'CONTINUIDAD', 'diferencial' => 'DIFERENCIAL', 'termografia' => 'TERMOGRAFÍA'], null, ['class' => 'form-control']) }}
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
   	@else
		<h3 class="text-uppercase mt-40">NO EXISTEN MEDICIONES DE TERMOGRAFÍA </h3>
	@endif
@endsection 

@section('javascript')
@stop
