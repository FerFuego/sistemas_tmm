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
            font-size: 12px;
            border-collapse:collapse;
        }

        td {
            padding: 5px;
            border: inset 0pt!important;
            border: inset 0px!important;
        }

        tr:nth-child(even) {background-color: #eee;}

        div {
            margin: 0;
            padding: 0;
        }

        h3 {
            font-size: 18px;
            text-align: center;
            padding: 25px 0;
            font-weight: 400;
        }
        span{
            font-weight: 500;
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
    </style>
</head>
<body onload="print()">
	<h3>MEDICIÓN DE RESISTENCIA DE PUESTA A TIERRA</h3>

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

    <div class="pdf-header">
        <div class="row">
            <div style="width:230px; display:inline-block; vertical-align: top; padding: 15px 10px 20px 0;">
                @if($value->image_1)
                    <img src="{{ base_path() . '/images/catalog/'.$value->image_1 }}" style="width: 100%;">
                @else
                    <img src="{{ base_path() . '/images/nophoto.png' }}" style="width: 100%; height: 100%;">
                @endif
                <div style="width:210px; height:30px;padding:10px;margin-top: 15px" class="bordered">
                    <div style="float: right; width:49%; vertical-align:middle; text-align:right;">
                        @if($criticidad)
                            <img src="{{ base_path() . '/images/'.$criticidad['rango'].'.png' }}" width="50px">
                        @endif
                    </div>
                    <div style="float: left width:49%; vertical-align:middle; margin-top: 10px;">
                        @if($criticidad)
                            Criticidad: {{ $criticidad['criticidad'] }}
                        @endif
                    </div>
                </div>
            </div>
            <div style="width:420px; display:inline-block; vertical-align: top; margin-top: 15px; margin-left: 20px;">
                <div class="white-box">
                    <table class="table table-bordered table-striped text-center" style="border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td class="w-10"><b>Detalle</b></td>
                                <td>{{ $value->details }}</td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Sector</b></td>
                                <td>{{ $value->sector }}</td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Valor</b></td>
                                <td> 
                                    @if($criticidad)
                                        @if($criticidad['rango'] == 'RANGO_1')  
                                            @if($value->equivalence) {{ $value->equivalence }} @else {{ $value->value }} ohm @endif <img src="{{ base_path().'/images/R_1.PNG' }}" title="valor normal" style="width:20px;margin-top: 6px;">
                                        @elseif($criticidad['rango'] == 'RANGO_2') 
                                            @if($value->equivalence) {{ $value->equivalence }} @else {{ $value->value }} ohm @endif <img src="{{ base_path().'/images/R_1.PNG' }}" title="valor incipiente" style="width:20px;margin-top: 6px;">
                                        @elseif($criticidad['rango'] == 'RANGO_3') 
                                            @if($value->equivalence) {{ $value->equivalence }} @else {{ $value->value }} ohm @endif <img src="{{ base_path().'/images/R_2.PNG' }}" title="valor pronunciada" style="width:20px;margin-top: 6px;"> 
                                        @else 
                                            @if($value->equivalence) {{ $value->equivalence }} @else {{ $value->value }} ohm @endif <img src="{{ base_path().'/images/R_3.PNG' }}" title="valor severa" style="width:20px;margin-top: 6px;">
                                        @endif
                                    @endif
                                </td>
                            </td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Valor máximo</b></td>
                                <td>{{ $value->value_max }} ohm</td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Observación</b></td>
                                <td>
                                    @php
                                        if(strpos($value->observation,'[')!==false){
                                            $string=false;
                                            foreach(json_decode($value->observation, true) as $obs){
                                                $string .= "- ".$obs."\r\n";
                                            }
                                        }else{
                                            $string=json_decode($value->observation);
                                        }
                                    @endphp
                                    {{ $string }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10"><b>Recomendación</b></td>
                                <td>
                                    <?php
                                        if(strpos($value->recommendation,'[')!==false){
                                            $string=false;
                                            foreach(json_decode($value->recommendation, true) as $obs){
                                                $string .= "- ".$obs."\r\n";
                                            }
                                        }else{
                                            $string=json_decode($value->recommendation);
                                        }
                                    ?>
                                    <p>{{ $string }}</p>
                                    <p>{{ $value->other }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>