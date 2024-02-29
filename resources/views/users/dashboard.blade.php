@extends('layouts.app')

@section('title-section', Auth::user()->name)

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
        <table id="latabla" class="table table-bordered-none text-center">
            <div class="white-box">
                <h4>REPORTES DE ALERTAS
                    @if ($alarms)
                        @php
                            $i=0;
                            $array_fecha =  array();
                        @endphp
                        <div class="pull-right">
                            <select name="date" id="date" {{-- onchange="filter_date(this.value);" --}}>
                                <option value="">Todas las alarmas</option>
                                @foreach($alarms as $a)
                                    @php
                                        if(!in_array(date_format(date_create($a['measurements_date']), 'Y-m'), $array_fecha)){
                                            $array_fecha[] = date_format(date_create($a['measurements_date']), 'Y-m');
                                        }
                                    @endphp
                                @endforeach
                                @foreach ($array_fecha as $f)
                                    @php
                                        $array = explode('-', $f);
                                        $ano = $array[0];
                                        $mes = $array[1];
                                        $mes = str_replace('01', 'Enero', $mes);
                                        $mes = str_replace('02', 'Febrero', $mes);
                                        $mes = str_replace('03', 'Marzo', $mes);
                                        $mes = str_replace('04', 'Abril', $mes);
                                        $mes = str_replace('05', 'Mayo', $mes);
                                        $mes = str_replace('06', 'Junio', $mes);
                                        $mes = str_replace('07', 'Julio', $mes);
                                        $mes = str_replace('08', 'Agosto', $mes);
                                        $mes = str_replace('09', 'Septiembre', $mes);
                                        $mes = str_replace('10', 'Octubre', $mes);
                                        $mes = str_replace('11', 'Noviembre', $mes);
                                        $mes = str_replace('12', 'Diciembre', $mes);
                                    @endphp

                                    <option value="{{ $array[1].'-'.$ano }}">{{ $mes.' '.$ano }}</option>

                                @endforeach
                            </select>
                        </div>
                    @endif
                </h4>
            </div>
            @if ($alarms)
                <div class="box-red box-alert-tmm">
                    <h4>ALERTAS
                        <div class="pull-right">
                            <i class="icon-bell"></i>
                        </div>
                    </h4>
                </div>

                <tbody>
                    <tr>
                        <td><b>Sucursal</b></td>
                        <td class="text-center"><b>Fecha de medición</b></td>
                        <td><b>Medición</b></td>
                        <td><b></b></td>
                        <td><b></b></td>
                        <td><b></b></td>
                    </tr>
                        @foreach($alarms as $a)
                            <tr>
                                <td>
                                    @foreach($branch as $b)
                                        @if($a['branch'] == $b->id)
                                            {{ $b->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">{{ date_format(date_create($a['measurements_date']), 'd-m-Y') }}</td>
                                <td class="text-capitalize">
                                    @if ($a['alarm']['type'] == 'diferencial')
                                        Diferenciales
                                    @else
                                        {{ $a['alarm']['type'] }}
                                    @endif
                                </td>
                                <td><div class="btn btn-default btn-custom-tmm btn-custom-tmm-delete">Urgente</div></td>
                                <td><a href="/{{ $a['alarm']['type'] }}/mediciones/ver/{{ $a['alarm']['idvalues'] }}" title=""><i class="icon-eye"></i></a></td>
                                <td><a href="{!! route('alarma.delete', [$a['alarm']['id']]); !!}" title=""><i class="icon-trash"></i></a></td>
                            </tr>
                        @endforeach
                </tbody>
            @endif
        </table>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
        <div class="white-box notifications">
            <h4>NOTIFICACIONES</h4>
            <table class="table table-bordered-none text-left">
                <tbody>
                    <tr>
                        <td style="width:20px;">
                             @if($payment)
                                @php $class = ''; @endphp
                                @if($payment->state == 'Al día') @php $class = 'success'; @endphp @endif
                                @if($payment->state == 'Por vencer') @php $class = 'warning'; @endphp @endif
                                @if($payment->state == 'Pendiente') @php $class = 'danger'; @endphp @endif
                            @endif                            
                            <i class="icon-check"></i>
                           
                        </td>
                        <td>
                            Estado de pago: 
                            @if($payment)
                                <span class="text-{{ $class }}">{{ $payment['state'] }}</span>
                            @endif
                        </td>
                        <td class="text-muted">
                            @if($payment)
                                {{ date_format(date_create($payment['date_next_pay']), 'd-m-Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20px;">                        
                            <i class="icon-list"></i>
                        </td>
                        <td>Tiene
                            @if($report)
                                {{ count($report) }}
                            @else
                                0
                            @endif  
                            Reportes</td>
                        <td class="text-muted">
                            @if($report)
                                @php
                                    $date = 0;
                                @endphp
                                @foreach($report as $a)
                                    @if($a['report']['date'] > $date)
                                        @php
                                            //Busca la fecha mas reciente
                                            $date = $a['report']['date'];
                                        @endphp
                                    @endif
                                @endforeach
                                {{ date_format(date_create($date), 'd-m-Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20px;">                            
                            <i class="icon-bell"></i>                         
                        </td>
                        <td>
                            Tiene
                            @if($alarms)
                                {{ count($alarms) }}
                            @else
                                0
                            @endif 
                            alertas
                        </td>
                        <td class="text-muted">
                            @if($alarms)
                                @php
                                    $date = 0;
                                @endphp
                                @foreach($alarms as $a)
                                    @if($a['alarm']['date'] > $date)
                                        @php
                                            //Busca la fecha mas reciente
                                            $date = $a['alarm']['date'];
                                        @endphp
                                    @endif
                                @endforeach
                                {{ date_format(date_create($date), 'd-m-Y') }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="row porcentaje row-in">
                @foreach($branch  as $b)
                    @if($criticidad)
                        @foreach($criticidad as $c)
                          @if($c['branch'] == $b->id)
                                <div class="col-lg-3 col-sm-6 row-in-br">
                                    <div class="col-in row">
                                        <div class="col-md-4 col-sm-4 col-xs-4"> 
                                            <a href="{!! route('usuarios.sucursal', [$user->id, $b->id]); !!}">
                                                <i class="icon-pie-chart text-muted"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                            <a href="{!! route('usuarios.sucursal', [$user->id, $b->id]); !!}">
                                                <h3 class="counter text-right text-{{ $c['class'] }}">
                                                    {{ $totalSucursal = number_format($c['criticidad']) }} %
                                                    <span>Nivel de Criticidad</span>
                                                </h3> 
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <a href="{!! route('usuarios.sucursal', [$user->id, $b->id]); !!}">
                                                <h5 class="text-muted m-t-0 m-b-0 vb">SUCURSAL: {{ $b->name }}</h5>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-{{ $c['class'] }}" role="progressbar" aria-valuenow="{{ $totalSucursal }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100" 
                                                    style="width: {{ $totalSucursal }}%"> 
                                                    <span class="sr-only">{{ $totalSucursal }}% Complete (success)</span> 
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                          @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
        <div class="col-md-6 col-lg-8 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">ULTIMAS MEDICIONES</h3>
                <div class="border-muted-tmm">
                    <i class="icon-bell" aria-hidden="true"></i>
                </div>
                <div class="table-responsive">
                    <div class="table-responsive">
                  @if($mediciones)
                      <table class="table text-center table-border-none">
                          <thead>
                              <tr>
                                  <th class="text-center">Sucursal</th>
                                  <th class="text-center">Fecha de medición</th>
                                  <th class="text-center">Analisis realizado</th>
                                  <th class="text-center">Descargar certificado</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($mediciones as $m)
                                  <tr>
                                      <td class="txt-oflo">{{ $m->place }}</td>
                                      <td>{{ date_format(date_create($m->date), 'd-m-Y') }}</td>
                                      <td class="txt-oflo text-capitalize">
                                        @if ($m->type == 'diferencial')
                                            Diferenciales
                                        @else
                                            {{ $m->type }}
                                        @endif
                                      </td>
                                      <td>
                                          @if(!empty($m->archivo_3))
                                            <a href="{{asset('files/certificates/'.$m->archivo_3)}}" target="_blank" title="Imagen de crokis de planta">
                                                
                                                    <i class="icon-cloud-download"></i>
                                               
                                            </a>
                                          @endif
                                          @if(!empty($m->archivo_2))
                                            <a href="{{asset('files/certificates/'.$m->archivo_2)}}" target="_blank" title="Certificado de Calibración">
                                                
                                                    <i class="icon-cloud-download"></i>
                                                
                                            </a>
                                          @endif
                                          @if(!empty($m->archivo_1))
                                            <a href="{{asset('files/certificates/'.$m->archivo_1)}}" target="_blank" title="Protocolo SRT 900/2015">
                                                
                                                    <i class="icon-cloud-download"></i>
                                                
                                            </a>
                                          @endif
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  @else
                    <hr><h5>No hay certificados de mediciones</h5>
                  @endif
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-12">
            <div class="white-box box-title-tmm-merge text-white">
                <div class="row">
                    <h3 class="box-title text-white">NOTICIAS</h3>
                    <div class="col-sm-12 col-xs-12 text-white">
                       
                    </div>
                </div>
            </div>
            <div class="white-box text-white fix-3 text-center">
                @if ($banner)
                    @foreach($banner as $b)
                    <div class="banners"> 
                        <a href="{{ asset('images/catalog/'.$b->imagen) }}" data-lightbox="image-1" data-title="Noticia"><img src="{{ asset('images/catalog/'.$b->imagen) }}"></a>
                    </div>
                    @endforeach
                @else
                    <p class="text-merge">No se encontraron noticias</p>
                @endif
            </div>
        </div>
    </div>
@endsection 

@section('javascript')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.uitablefilter.js') }}"></script>
    <script language="javascript">
              var fill = jQuery.noConflict();
              theTable = fill("#latabla");
              fill(function() {
                  theTable = $("#latabla");
                  $("#date").change(function() {
                      fill.uiTableFilter(theTable, this.value);
                  });
              });
    </script>
{{--     <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        function filter_date(val){
                        
            $.ajax({
                    data: "val="+ val + "&_token={{ csrf_token()}}",
                    url: "{{ route('getdate')}}",
                    method: "POST",
                    beforeSend: function(){
                        $("#alarms_table").html("Procesando, espere por favor...");
                    },
                    success: function(data){

                        // if(data.datos == false){
                        //     alert(data.sms);
                        //     return;
                        // }

                        // var chtml="";
                        // for (datas in data.observation) {
                        //     chtml += data.observation[datas]+'\n';
                        // };
                        $("#alarms_table").html(data.datos);

                        // var dhtml="";
                        // for (datas in data.datos) {
                        //   dhtml+= data.datos[datas]+'<br>';
                        // };
                        // $("#piezas2").html(dhtml);
                    }
                });
        }
    </script> --}}

@stop
