<!DOCTYPE html>  
<html>
<head>
    <style type="text/css">
        body{
            width: 100%;
            padding:20px;
            border-top: 10px solid #ba0975;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        }
        table{
            width: 100%;
            position: relative;           
        }

        h1, h2, h3, p, b, td {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            margin: 0;
        }
        
        table, td, th {
            margin: 0;
            position: relative;
        }

        td {
            border: 1px solid #eee;
            padding: 5px;
        }

        div {
            margin: 0;
            padding: 0;
        }

        h3 {
            text-align: center;
            padding: 25px 0 50px 0;
        }

        .pdf-header {
            width: 100%;
            margin-bottom: 50px;
        }

        .row {
            width: 100%;
            clear: both;
            height: auto;
        }

        .col-md-3 {
            width: 25%;
            float: left;
        }

        .col-md-4 {
            width: 33%;
            float: left;
        }

        .col-md-6 {
            width: 50%;
            float: left;
            padding: 5px;
        }

        .col-md-8 {
            width: 66%;
            float: left;
            padding: 5px;
        }

        .col-md-12 {
            width: 100%;
            float: left;
        }

        .bordered {
            border: 1px solid #eee;
        }
    </style>
</head>
<body>
      <h3>MEDICIONES SRT {{ $sucursales->name }}</h3>
       <div class="row"> 
          <div  style="width: 100%;">
            <div class="white-box">
              <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <td colspan="4" class="text-left">
                        <h3 class="text-merge"><b>INFORMES 2018 SRT 900/2015</b></h3>
                      </td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr> 
                      <td class="text-center bordered" style="padding-left: 10px; border-right: none;"><b>Fecha</b></td>
                      <td class="text-center bordered" style="padding-left: 10px; border-right: none;"><b>Medición</b></td>
                      <td class="text-center bordered" style="padding-left: 10px; border-right: none;"><b>Nivel de Criticidad General</b></td>
                      <td class="text-center bordered" style="padding-left: 10px;"><b>Vigencia</b></td>
                    </tr>
                    @foreach($medidas as $m)
                      @if($sucursales->id == $m->idbranch_office)
                        <tr style="width: 750px;">
                          <td class="text-center bordered" style="padding-left: 10px; border-right: none;border-top: none;">{{ date_format(date_create($m->date), 'd-m-Y') }}</td>
                          <td class="text-capitalize text-center bordered" style="padding-left: 10px; border-right: none;border-top: none;">{{ $m->type }}</td>
                          <td class="text-center bordered" style="padding-left: 10px; border-right: none;border-top: none;">
                            @if($m->type == 'termografia')
                                @foreach($termografia as $t)
                                  @if($t['id'] == $m->id)
                                    <span>{{ $t['criterion'] }}%</span>
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-{{ $t['class'] }} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $t['criterion'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $t['criterion'] }}%;"></div>
                                    </div>
                                  @endif
                                @endforeach
                            @endif
                            @if($m->type == 'pat')
                                @foreach($puestatierra as $pt)
                                  @if($pt['id'] == $m->id)
                                    <span>{{ $pt['criterion'] }}%</span>
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-{{ $pt['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $pt['criterion'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $pt['criterion'] }}%;"></div>
                                    </div>
                                  @endif
                                @endforeach
                            @endif
                            @if($m->type == 'continuidad')
                                @foreach($criticidadCyD as $cyd)
                                  @if($cyd['id'] == $m->id)
                                        <span>{{ number_format($cyd['criticidad'], 2) }}%</span>
                                        <div class="progress">
                                          <div class="progress-bar progress-bar-{{ $cyd['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $cyd['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $cyd['criticidad'] }}%;"></div>
                                        </div>
                                  @endif
                                @endforeach
                            @elseif($m->type == 'diferencial')
                                @foreach($criticidadCyD as $cyd)
                                  @if($cyd['id'] == $m->id)
                                        <span>{{ number_format($cyd['criticidad'], 2) }}%</span>
                                        <div class="progress">
                                          <div class="progress-bar progress-bar-{{ $cyd['class']}} wow animated progress-animated" role="progressbar" aria-valuenow="{{ $cyd['criticidad'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $cyd['criticidad'] }}%;"></div>
                                        </div>
                                  @endif
                                @endforeach
                            @endif
                          </td>
                          <td class="text-center bordered" style="padding-left: 10px; border-top: none;">
                            @foreach($vigencia as $v)
                              @if($v['id'] == $m->id)
                                <span class="{{ $v['class'] }}">{{ $v['vigencia'] }}</span>
                              @endif
                            @endforeach
                          </td>
                        </tr>
                      @endif
                    @endforeach
                  </tbody>
                </table>
            </div>
          </div>
        </div>
  </body>
</html>
