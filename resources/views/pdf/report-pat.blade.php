<!DOCTYPE html>  
<html>
<head>
    <style type="text/css">
        body{
            width: 100%;
            padding:0px;
            font-size: 11px;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            margin-top: 0px!important;
            padding-top: 0px!important;
            height: 700px;
            border-bottom: 10px solid #ba0975;
        }
        table{
            width: 100%;
            position: relative;           
            border: 1px solid #eee;
        }

        h1, h2, h3, p, b, td {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            margin: 0;
        }
        
        table, td, th {
            margin: 0;
            position: relative;
        }
        .b-l{
            border-left: 1px solid #eee;
        } 
        .b-r{
            border-right: 1px solid #eee;
        } 
        .b-t{
            border-top: 1px solid #eee;
        } 
        .b-b {
            border-bottom: 1px solid #eee;
        }
        table{
            border-collapse:collapse;
        }

        td {
            padding: 2px;
            border: inset 0pt!important;
            border: inset 0px!important;
        }

        tr:nth-child(even) {background-color: #eee;}

        div {
            margin: 0;
            padding: 0;
        }

        h3 {
            font-size: 16px;
            text-align: center;
            padding: 15px 0;
            font-weight: 400;
            color: #fff;
        }
        span{
            font-weight: 500;
        }

        hr{
            border: 3px solid #fff;
            margin-bottom: 1px;
        }

        .pdf-header {
            width: 100%;
            margin-bottom: 10px;
        }
        .pdf-body{
            height: 250px;
            margin-bottom: 10px;
        }
        .membrete{
            background-color: #ba0975;
            margin-bottom: 0px;
            text-align: right;
            height: 40px!important;
            position: absolute;
            top: -40px;
            margin-top: 0px!important;
            padding-top: 0px!important;
        }
        .membrete h3{
           padding: 5px 15px;
        }
        .membrete img{
            padding: 2px 15px;
        }

        .row {
            width: 100%;
            clear: both;
            height: auto;
        }

        .col-md-2 {
            width: 24%;
            float: left;
            padding: 5px;
        }

        .col-md-3 {
            width: 25%;
            float: left;
            padding: 5px;
        }

        .col-md-4 {
            width: 33%;
            float: left;
            padding: 5px;
        }

        .col-md-5 {
            width: 43%;
            float: left;
            padding: 5px;
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

        .height-100{
            margin-top: -40px;
            padding: 10px;
        }

        .bordered {
            border: 1px solid #eee;
            font-size: 12px;
        }
        .bordered-w {
            border: 1px solid #fff;
            font-size: 12px;
        }
        .clearfix{
            clear: both;
        }
        .w-30{
            width: 30%;
        }
        .w-10{
            width: 10%;
        }
        .back-grey{
            background-color: #eee;
        }
        .border-none{
            border: none;
        }
        .text-uppercase{
            text-transform: uppercase;
        }
        .med-min-little{
            width: 100px;
        }
        .med-min{
            width: 150px;
        }
        .med-med{
            width: 250px;
        }
        .med-max{
            width: 400px;
        }
        .b-r-w{
            border-right:1px solid #fff!important;
        }
        .b-r-g{
            border-right:1px solid #eee!important;
        }
        h1.SaltoDePagina {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="row membrete">
        <div class="col-md-8">
            <h3>MEDICIONES DE RESISTENCIA DE PUESTA A TIERRA</h3>
        </div>
        <div class="col-md-4">
            <img src="{{  base_path() . '/images/logo-white.png' }}" width="70px">
        </div>
    </div>

    @php
        $bandera = false;
        $i=0;
    @endphp

    <div class="pdf-header">
        <div class="row">
            <table>
                <tr>
                    <td class="med-min back-grey"><b>Fecha:</b></td>
                    <td class="med-min back-grey b-r-w">{{ date_format(date_create($medida->date), 'd-m-Y') }}</td>
                    <td class="med-min-little back-grey"><b>Reglamentacion:</b></td>
                    <td class="med-min back-grey">{{ $medida->regulation }}</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="med-min"><b>Establecimiento y Sucursal:</b></td>
                    <td class="med-min b-r-g">{{$user->name}}/{{ $medida->place }}</td>
                    <td class="med-min-little"><b>Instrumento:</b></td>
                    <td class="med-min">{{ $medida->instrument }}</td>
                </tr>
            </table>
        </div>
    </div>

    @foreach ($valores as $v)

        @if ($bandera == true)

            @php $i=0; $bandera= false; @endphp

            <h1 class="SaltoDePagina"></h1>

            <div class="row membrete">
                <div class="col-md-8">
                    <h3>MEDICIONES DE RESISTENCIA DE PUESTA A TIERRA</h3>
                </div>
                <div class="col-md-4">
                    <img src="{{  base_path() . '/images/logo-white.png' }}" width="70px">
                </div>
            </div>

        @endif

        <div class="pdf-body">
            <div class="row">
                <div style="width:300px; display:inline-block; vertical-align: top;">
                    @if($v->image_1)
                        <img src="{{ base_path() . '/images/catalog/'.$v->image_1 }}" style="width: 100%;height: 100%;">
                    @else
                        <img src="{{ base_path() . '/images/nophoto.png' }}" style="width: 100%; height: 100%;">
                    @endif
                </div>
                <div style="width:400px; display:inline-block; vertical-align: top; margin-left: 10px;">
                    <table class="table table-bordered table-striped text-center" style="border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td class="w-10"><b>Detalle</b></td>
                                <td>{{ $v->details }}</td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Sector</b></td>
                                <td>{{ $v->sector }}</td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Valor</b></td>
                                <td> 
                                    <div style="position: relative;">
                                        @if($criticidad)
                                            @foreach ($criticidad as $crit)
                                                @if($crit['value_id'] == $v->id)
                                                    @if($crit['rango'] == 'RANGO_1')  
                                                        @if($v->equivalence) {{ $v->equivalence }} @else {{ $v->value }} ohm @endif 
                                                        <img src="{{ base_path().'/images/R_1.PNG' }}" title="valor normal" style="width:15px;position: absolute; top:0px;">
                                                    @elseif($crit['rango'] == 'RANGO_2') 
                                                        @if($v->equivalence) {{ $v->equivalence }} @else {{ $v->value }} ohm @endif 
                                                        <img src="{{ base_path().'/images/R_1.PNG' }}" title="valor incipiente" style="width:15px;position: absolute; top:0px;">
                                                    @elseif($crit['rango'] == 'RANGO_3') 
                                                        @if($v->equivalence) {{ $v->equivalence }} @else {{ $v->value }} ohm @endif 
                                                        <img src="{{ base_path().'/images/R_2.PNG' }}" title="valor pronunciada" style="width:15px;position: absolute; top:0px;"> 
                                                    @else 
                                                        @if($v->equivalence) {{ $v->equivalence }} @else {{ $v->value }} ohm @endif 
                                                        <img src="{{ base_path().'/images/R_3.PNG' }}" title="valor severa" style="width:15px;position: absolute; top:0px;">
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                            </td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Valor máximo</b></td>
                                <td>{{ $v->value_max }} ohm</td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Observación</b></td>
                                <td>
                                    @php
                                        if(strpos($v->observation,'[')!==false){
                                            $string=false;
                                            foreach(json_decode($v->observation, true) as $obs){
                                                $string .= "- ".$obs."\r\n";
                                            }
                                        }else{
                                            $string=json_decode($v->observation);
                                        }
                                    @endphp
                                    {{ $string }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Recomendación</b></td>
                                <td>
                                    <?php
                                        if(strpos($v->recommendation,'[')!==false){
                                            $string=false;
                                            foreach(json_decode($v->recommendation, true) as $obs){
                                                $string .= "- ".$obs."\r\n";
                                            }
                                        }else{
                                            $string=json_decode($v->recommendation);
                                        }
                                    ?>
                                    <p>{{ $string }}</p>
                                    <p>{{ $v->other }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="width:200px; height:30px;padding:5px;margin-top: 15px; position: relative;" class="bordered">
                        <div style="float: right; width:49%; vertical-align:middle; text-align:right;">
                            @if($criticidad)
                                @foreach ($criticidad as $crit)
                                    @if ($crit['value_id'] == $v->id)
                                        <img src="{{ base_path() . '/images/'.$crit['rango'].'.png' }}" width="50px">
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div style="float: left; vertical-align:middle; margin-top: 10px;">
                            @if($criticidad)
                                @foreach ($criticidad as $crit)
                                    @if ($crit['value_id'] == $v->id)
                                        Criticidad: {{ $crit['criticidad'] }}
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="clearfix"></div>
        @if ($bandera == false && $i == 2)
            @php $bandera = true; @endphp
        @endif

        @php $i++; @endphp

    @endforeach

</body>
</html>