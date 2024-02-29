@extends('layouts.app')

@section('title-section','MEDICIONES DE DIFERENCIALES - '. $sucursal->name)

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li class="capitalize"><a href="{{ url('/'.$type.'/sucursales') }}">Diferenciales / Sucursales</a></li>
    <li><a href="{{ url('/usuarios/'.$user->id.'/sucursal/'.$sucursal->id) }}">{{ $sucursal->name }}</a></li>
    <li class="active">Detalle</li>
  </ol>
@endsection

@section('content')
    <h3 class="text-uppercase">MEDICIÓN DE DIFERENCIALES -  {{ $user->name }} / {{ $sucursal->name }}</h3>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="white-box">
            <table class="table pat-table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="text-center">Detalle</th>
                    <th class="text-center">Mediciones totales</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  @php 
                      $i = 0;
                      $val = 0; 
                  @endphp
                  @foreach($valores as $v)
                    <tr>
                        <td>{{ $v->details }}</td>
                        <td>
                          @php $i=0; @endphp
                          @foreach(json_decode($v->value, true) as $a)
                               @php 
                                  $val = $val + $a[0];
                                  $i++;
                               @endphp
                          @endforeach
                          {{ $i }}
                        </td>
                          @if($criticidad)
                              @foreach ($criticidad as $cr)
                                @if ($cr['value_id'] == $v->id)
                                  @php $rango_local = $cr['rango']; @endphp
                                @endif
                              @endforeach
                          @endif
                          <td  @if($rango_local == 'RANGO_2') class="back-normal" @endif
                            @if($rango_local == 'RANGO_3') class="back-pronunciado" @endif
                            @if($rango_local == 'RANGO_4') class="back-several" @endif > 
                          <img src="{{ asset('images/'.$rango_local.'.svg') }}" width="50px">
                        </td>
                        <td><a href="{!! url('./'.$medida->type.'/mediciones/ver/'.$v->id) !!}" class="fa-link-tmm text-merge">Ver detalle</a></td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
          {{-- <a href="{!! url('exportMedition/'.$user->id.'/'.$sucursal->id.'/'.$medida->type.'/'.$medida->id); !!}" class="btn btn-default btn-custom-tmm btn-custom-tmm-active">Exportar listado</a> --}}
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="white-box">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <th colspan="2" class="text-center">Información adicional</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($medida->archivo_3))
                      <tr>
                          <td class="b-r-none b-b-none">Imagen de crokis de planta</td>
                          <td class="b-l-none b-b-none text-center"><a href="{{asset('files/certificates/'.$medida->archivo_3)}}" target="_blank"><i class="icon-cloud-download"></i></a></td>
                      </tr>
                    @endif
                    @if(!empty($medida->archivo_2))
                      <tr>
                          <td class="b-r-none b-b-none">Certificado de Calibración</td>
                          <td class="b-l-none b-b-none text-center"><a href="{{asset('files/certificates/'.$medida->archivo_2)}}" target="_blank"><i class="icon-cloud-download"></i></a></td>
                      </tr>
                    @endif
                    @if(!empty($medida->archivo_1))
                      <tr>
                          <td class="b-r-none b-b-none">Protocolo SRT 900/2015</td>
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
