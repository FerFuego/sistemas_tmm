@extends('layouts.app')

@section('title-section',$sucursales->name)

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li class="capitalize"><a href="{{ url('/'.$type.'/sucursales') }}">{{ $type }} / Sucursales</a></li>
    <li class="active capitalize">{{ $sucursales->name }}</li>
  </ol>
@endsection

@section('content')
  @if ($medidas != '[]')

    @php $verificador = false; @endphp
    @foreach($medidas as $m)
      @if($sucursales->id === $m->idbranch_office)
        @php $verificador = true; @endphp
      @endif
    @endforeach

    	<div class="row">
    		<div class="col-md-6">
          @if ($alarma != '[]')
              @php $type = false; @endphp
                @foreach($alarma as $a)
                  @if($a->type == 'continuidad')
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

          @if($verificador == true)
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
                          @elseif($vig['validity']=='Medición no vigente')
                            <li><i class="fa fa-circle fa-2x text-success vigency-trans"></i></li>
                            <li><i class="fa fa-circle fa-2x text-warning vigency-trans"></i></li>
                            <li><i class="fa fa-circle fa-3x text-danger"></i></li>
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
          @endif
    		</div>
    	</div>
      
      <h3 class="text-uppercase mt-40">LISTADO DE CONTINUIDAD - {{ $sucursales->name }}</h3>

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="white-box">
            @if($verificador == true)
            <table class="table pat-table table-bordered text-center">
                  <tr> 
                    <td class="text-center"><b>Fecha</b></td>
                    <td class="text-center"><b>Cant de análisis</b></td>
                    <td class="text-center"><b>Nivel de Criticidad General</b></td>
                    <td class="text-center"></td>
                  </tr>
                  @foreach($medidas as $m)
                    @if($sucursales->id === $m->idbranch_office)
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
                          @foreach($criticidadCyD as $cyd)
                            @if($cyd['id'] == $m->id)
                                  <span>{{ number_format($cyd['criticidad'], 2) }}%</span>
                                  <div class="progress">
                                      <div class="progress-bar progress-bar-{{ $cyd['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $cyd['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $cyd['criticidad'] }}%;"></div>
                                  </div>
                              @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                          <a href="{!! route('sucursal.show', [$sucursales->id,'continuidad', $m->id]); !!}" class="fa-link-tmm text-merge">ver detalle</a>
                        </td>
                      </tr>
                    @endif
                  @endforeach
              </table>
              @else
                <p class="text-uppercase mt-40">NO EXISTEN MEDICIONES DE CONTINUIDAD </p>
              @endif
          </div>
        </div>
      </div>
    @else
      <h3 class="text-uppercase mt-40">NO EXISTEN MEDICIONES DE CONTINUIDAD </h3>
    @endif
@endsection 

@section('javascript')
@stop
