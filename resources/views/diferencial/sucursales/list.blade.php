@extends('layouts.app')

@section('title-section','DIFERENCIALES')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li class="capitalize">Diferenciales / Sucursales</li>
  </ol>
@endsection

@section('content')
    @if ($medidas != '[]')

      <h4>LISTADO DE SUCURSALES</h4>

      <div class="row">
          <div class="white-box col-md-12">
              <table class="table pat-table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="text-center">Sucursal</th>
                    <th class="text-center">Últimas Diferenciales</th>
                    <th class="text-center">Nivel de criticidad general de la medición</th>
                    <th class="text-center">Vigencia medición</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($medidas as $m)
                    <tr>
                        <td>
                          @if($sucursales != '[]')
                            @foreach($sucursales as $s)
                              @if($m->idbranch_office == $s->id)
                                {{ $s->name }}
                              @endif
                            @endforeach
                          @endif
                        </td>
                        <td>{{ date_format(date_create($m->date), 'd-m-Y') }}</td>
                        <td>
                            @foreach ($criticidadCyD as $crit)
                            @if($crit['id'] == $m->id)
                            @php $class = ''; @endphp
                            @if($crit['criticidad'] <= 20) @php $class = 'success'; @endphp @endif
                            @if($crit['criticidad'] > 20 && $crit['criticidad'] <= 60) @php $class = 'warning'; @endphp @endif
                            @if($crit['criticidad'] > 60) @php $class = 'danger'; @endphp @endif
                              <span>{{ number_format($crit['criticidad'],2) }}%</span>
                              <div class="progress">
                                  <div class="progress-bar progress-bar-{{ $class }} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $crit['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $crit['criticidad'] }}%;"></div>
                              </div>
                            @endif
                          @endforeach
                        </td>
                        </td>
                        <td> 
                            @foreach($vigencia as $v)
                              @if($v['id'] == $m->id)
                                <span class="{{ $v['class'] }}">{{ $v['vigencia'] }}</span>
                              @endif
                            @endforeach
                        </td>
                        <td>
                          <a href="{!! url('./'.$m->type.'/sucursal/'.$m->idbranch_office.'/listado') !!}" class="fa-link-tmm text-merge">Ver</a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
      </div>

      {{-- <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4>ESTADISTICAS DE PAT DE SUCURSALES EN GENERAL</h4>
          <div class="white-box">
               
            <ul class="list-inline text-center m-t-40">
              @php
                $i = 0;
                $color = ['#910058','#001C57','#ff6849','#fad0c3','#fdc006','#808f8f','#ab8ce4','#13dafe','#99d683','#03a9f3','#fb9678'];
              @endphp
              @foreach($sucursales as $s)
                  <li>
                      <h5><i class="fa fa-circle m-r-5" style="color: {{ $color[$i] }};"></i>{{ $s->name }}</h5>
                  </li>
                  @php $i++; @endphp
              @endforeach
              </ul>
              <div id="morris-area-chart" style="height: 340px;"></div>
          </div>
        </div>
      </div> --}}
    @else
      <h3 class="text-uppercase mt-40">NO EXISTEN MEDICIONES DE DIFERENCIALES </h3>
    @endif
@endsection 

@section('javascript')
   {{--  <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script> --}}

   {{--  @php $array = []; $anios = []; $band = false; @endphp
    @foreach ($criticidad as $c)
      @foreach($c['criticidad'] as $a)
        @if ($band != $a->anio)
            @php $anios[] = $a->anio; $band = $a->anio; @endphp
        @endif
        @php 
            $x=0; $i=0; $diferencial=0;
              foreach(json_decode($a->value, true) as $v){
                  $x = $x + $v[0];
                  $i++;
              }
              if($x>0){
                  $diferencial = $x / $i;
              }else{
                  $diferencial = 0;
              }
              if ($diferencial > 100){
                $criticidad = 100; 
              }else{
                $criticidad = $diferencial; 
              }
            $array[] = array('period' => $a->anio,'branch' => $c['branch'],'criticidad' => $criticidad); 
        @endphp
      @endforeach
    @endforeach --}}
    
    {{-- <script type="text/javascript">
      Morris.Area({
            element: 'morris-area-chart',
            data: [
                      {
                        period: '2016',
                        @foreach ($sucursales as $s)
                          {{ $s->id}}:0,
                        @endforeach
                      },
                  @foreach (array_unique($anios) as $a)
                          @php $band = $a; $x=''; @endphp
                          {
                            @if ($band != $x)
                              @php $x = $band; $h=false;@endphp
                              period: '{{ $band }}',
                            @endif
                            @foreach ($sucursales as $s)
                              @foreach ($array as $a)
                                @if ($s->id == $a['branch'] && $a['period'] == $band)
                                  {{ $s->id.':'.$a['criticidad'] }},
                                  @php $h=true; @endphp
                                @endif
                              @endforeach 
                              @if ($h==false)
                                {{ $s->id.':0' }},
                              @endif
                            @endforeach
                          }, 
                      @endforeach
                  ],
                    lineColors: ['#910058','#001C57','#ff6849','#fad0c3','#fdc006','#808f8f','#ab8ce4','#13dafe','#99d683','#03a9f3','#fb9678'],
                    xkey: 'period',
                    ykeys: [
                        @foreach ($sucursales as $s)
                          '{{ $s->id }}',
                        @endforeach
                    ],
                    labels: [
                        @foreach ($sucursales as $s)
                          '{{ $s->name }}',
                        @endforeach
                    ],
                    pointSize: 0,
                    lineWidth: 0,
                    resize:true,
                    fillOpacity: 0.8,
                    behaveLikeLine: true,
                    gridLineColor: '#e0e0e0',
                    hideHover: 'auto'
        });
  </script> --}}
@stop