<!DOCTYPE html>  
<html>
<head>
    <style type="text/css">
        body{
            width: 100%;
            padding:20px;
            font-size: 12px;
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
        }

        td {
            padding: 5px;
        }

        /*tr:nth-child(even) {background-color: #f2f2f2;}*/

        div {
            margin: 0;
            padding: 0;
        }

        h3 {
            font-size: 18px;
            text-align: left;
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
        .med-med-2{
            width: 300px;
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
	<h3>ANÁLISIS TERMOGRÁFICO Nº {{ $value->value_num }}</h3><hr>

    <div class="pdf-header">
        <div class="row">
            <table>
                <tr>
                    <td class="med-min-little back-grey"><b>Fecha:</b></td>
                    <td class="med-med-2 back-grey b-r-w">{{ date_format(date_create($medida->date), 'd-m-Y') }}</td>
                    <td class="med-min-little text-center" align="center" rowspan="2">
                        @if($value->criterion == 'Normal')
                            <img src="{{ asset('/images/RANGO_1.png') }}" width="90px">
                            @php $criticidad_name = 'Normal'; @endphp
                        @elseif($value->criterion == 'Regular' || $value->criterion == 'Incipiente')
                            <img src="{{ asset('/images/RANGO_2.png') }}" width="90px">
                            @php $criticidad_name = 'Incipiente'; @endphp
                        @elseif($value->criterion == 'Pronunciado')
                            <img src="{{ asset('/images/RANGO_3.png') }}" width="90px">
                            @php $criticidad_name = 'Pronunciada'; @endphp
                        @elseif($value->criterion == 'Severo')
                            <img src="{{ asset('/images/RANGO_4.png') }}" width="90px">
                            @php $criticidad_name = 'Severa'; @endphp
                        @endif
                        <br>Criticidad: {{ $criticidad_name }}
                    </td>
                </tr>
                <tr>
                    <td class="med-min-little"><b>Detalle:</b></td>
                    <td class="med-med b-r-g">{{ $value->title }}</td>                
                </tr>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div style="width:350px;display:inline-block;vertical-align:top;margin-left: 10px;">
            <h3>IMAGEN TERMOGRÁFICA</h3>
            <div class="white-box">
                @if($value->image_1)
                    <img src="{{ asset('images/catalog/'.$value->image_1) }}" style="width:100%">
                @else
                    <img src="{{ asset('images/nophoto.svg') }}" style="width:100%">
                @endif
            </div>
        </div>
        <div style="width:350px;display:inline-block;vertical-align:top;">
            <h3>IMAGEN DIGITAL</h3>
            <div class="white-box">
                @if($value->image_1)
                    <img src="{{ asset('images/catalog/'.$value->image_2) }}" style="width:100%">
                @else
                    <img src="{{ asset('images/nophoto.svg') }}" style="width:100%">
                @endif
            </div>
        </div>

        <div class="clearfix"></div>

        @if($value->image_3)
        <div class="col-md-12">
             <img src="{{ asset('images/catalog/'.$value->image_3) }}" style="width: 100%; height: 100%;">
             <br><br>
        </div>
        @endif

    </div>

    <div class="clearfix"></div>

   <div class="white-box" style="width: 95%; margin: 20px 0 30px 0;">
        <table>
            <tbody>
                <tr>
                    <td class="b-r w-30"><span>Observación:</span></td>
                    <td>
                        @php
                            if(strpos($value->recommendation,'[')!==false){
                                $string=false;
                                foreach(json_decode($value->recommendation, true) as $obs){
                                    $string .= $obs.". ";
                                }
                            }else{
                                $string=json_decode($value->recommendation);
                            }
                        @endphp                
                        <p>{{ $string }}</p>
                        <p>{{ $value->other }}</p>
                    </td>
                </tr>
            </tbody>
        </table>    
    </div>

   <div class="white-box" style="width: 95%; margin-top: 20px;">
        <table>
            <tbody>
                <tr class="back-grey"> 
                    <td class="b-b" colspan="3"><span>Relevamiento visual del tablero </span></td>
                </tr>
                <tr>
                    <td class="b-r w-30"><span>Estado del tablero:</span></td>
                    <td class="text-center w-10 b-r">
                        @if($value->state == 'Normal')
                            <img src="{{ asset('images/normal.png') }}">
                        @elseif($value->state == 'Regular')
                            <img src="{{ asset('images/regular.png') }}">
                        @elseif($value->state == 'Malo')
                            <img src="{{ asset('images/malo.png') }}">
                        @endif
                    </td>
                    <td>
                        @php
                            if(strpos($value->observation,'[')!==false){
                                $string=false;
                                foreach(json_decode($value->observation, true) as $obs){
                                    $string .= "- ".$obs."\n";
                                }
                            }else{
                                $string=json_decode($value->observation);
                            }
                        @endphp
                        {{ $string }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @if($value->state != 'Normal')
        <div class="white-box" style="width: 100%; margin-top: 40px;">
            <table class="border-none">
                <tr class="border-none">
                    <td class="w-30">Corrección de la falla</td>
                    <td>Fecha:</td>
                    <td>Firma:</td>
                </tr>
            </table>
        </div>
    @endif
</body>

</html>