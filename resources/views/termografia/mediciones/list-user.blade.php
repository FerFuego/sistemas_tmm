@extends('layouts.app')

@section('title-section','MEDICIONES DE TERMOGRAFÍA - '. $sucursal->name)

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li class="capitalize"><a href="{{ url('/'.$type.'/sucursales') }}">{{ $type }} / Sucursales</a></li>
    <li><a href="{{ url('/usuarios/'.$user->id.'/sucursal/'.$sucursal->id) }}">{{ $sucursal->name }}</a></li>
    <li class="active">Detalle</li>
  </ol>
@endsection

@section('content')
    <h3 class="text-uppercase">MEDICIÓN DE TERMOGRAFÍA -  {{ $user->name }} / {{ $sucursal->name }}</h3>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="white-box">
                <table class="table pat-table table-bordered text-center">
                    <thead>
                      <tr>
                        <th class="text-center">Nº análisis</th>
                        <th class="text-center">Lugar</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Estado</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($valores as $v)
                        <tr>
                            <td>{{ $v->value_num }}</td>
                            <td class="width-max-tmm">{{ $v->title }}</td>
                            <td class="width-max-tmm">
                                @php
                                    if(strpos($v->recommendation,'[')!==false){
                                        $string=false;
                                        foreach(json_decode($v->recommendation, true) as $obs){
                                            $string .= "- &nbsp;".$obs."\n";
                                        }
                                    }else{
                                        $string=json_decode($v->recommendation);
                                    }
                                @endphp
                                @if ($string)
                                  {{ $string }}
                                @endif
                                @if ($string && $v->other)
                                  <br>
                                @endif
                                @if ($v->other)
                                  - &nbsp;{{ $v->other }}
                                @endif
                            </td>
                            <td @if($v->criterion == 'Incipiente') class="back-normal" @endif
                                @if($v->criterion == 'Pronunciado') class="back-pronunciado" @endif
                                @if($v->criterion == 'Severo') class="back-several" @endif>
                                @if($v->criterion == 'Normal')
                                    <img src="{{ asset('images/RANGO_1.svg') }}"  width="50">
                                @elseif($v->criterion == 'Regular' || $v->criterion == 'Incipiente')
                                    <img src="{{ asset('images/RANGO_2.svg') }}"  width="50">
                                @elseif($v->criterion == 'Pronunciado')
                                    <img src="{{ asset('images/RANGO_3.svg') }}"  width="50">
                                @elseif($v->criterion == 'Severo')
                                    <img src="{{ asset('images/RANGO_4.svg') }}"  width="50">
                                @endif
                            </td>
                            <td><a href="{!! url('./'.$medida->type.'/mediciones/ver/'.$v->id) !!}" class="text-merge">Ver detalle</a></td>
                        </tr>
                        @endforeach                    
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                {{-- <a href="{!! url('exportMedition/'.$user->id.'/'.$sucursal->id.'/'.$medida->type.'/'.$medida->id); !!}" class="btn btn-default btn-custom-tmm btn-custom-tmm-active">Exportar listado</a> --}}
            </div>
        </div>
    	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    		<div class="white-box">
    			<table class="table table-bordered text-center">
	              <thead>
	                <tr>
	                  <th colspan="2" class="text-center">Información adicional</th>
	                </tr>
	              </thead>
	              <tbody>
                    @if(!empty($medida->archivo_2))
                      <tr>
                          <td class="b-r-none b-b-none">Certificado de Calibración</td>
                          <td class="b-l-none b-b-none text-center"><a href="{{asset('files/certificates/'.$medida->archivo_2)}}" target="_blank"><i class="icon-cloud-download"></i></a></td>
                      </tr>
                    @endif
                    @if(!empty($medida->archivo_1))
                      <tr>
                          <td class="b-r-none b-b-none">Relevamiento de termografía</td>
                          <td class="b-l-none b-b-none text-center"><a href="{{asset('files/certificates/'.$medida->archivo_1)}}" target="_blank"><i class="icon-cloud-download"></i></a></td>
                      </tr>
                    @endif
                    @foreach($archivos as $ach)
                      <tr>
                          <td class="b-r-none b-b-none">{{ $ach->name}}</td>
                          <td class=" text-center b-l-none b-b-none"><a href="{{asset('files/certificates/'.$ach->file)}}" target="_blank"><i class="icon-cloud-download" aria-hidden="true"></i></a></td>
                      </tr>
                    @endforeach
                    <tr>
                      <td class="b-r-none"></td>
                      <td class="b-l-none"></td>
                    </tr>
	              </tbody>
	        	</table>
    		</div>
    	</div>
    </div>

@endsection 

@section('javascript')
@stop
