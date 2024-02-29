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
            font-size: 12px;
            border-collapse:collapse;
        }

        td {
            padding: 5px;
            border: inset 0pt;
            border: inset 0px;
        }

        tr:nth-child(even) {border:1px solid #eee!important;}

        div {
            margin: 0;
            padding: 0;
        }

        h3 {
            font-size: 18px;
            text-align: left;
            padding: 5px;
            font-weight: 400;
        }
        span{
            font-weight: 500;
        }

        .table-bordered {
            border: 1px solid #eee;
        }

        .pdf-header {
            width: 100%;
            margin-bottom: 10px;
        }
        .pdf-body {
            width: 100%;
        }

        .membrete{
            background-color: #ba0975;
            margin-bottom: 0px;
            text-align: right;
            height: 40px!important;
            position: absolute;
            top: -30px;
            margin-top: 0px!important;
            padding-top: 0px!important;
        }
        .membrete h3{
           padding: 5px 15px;
           color: #fff;
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
        .med-mini{
            width: 60px;
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
        .word-break{
            word-wrap: break-word;
        }
    </style>
</head>
<body onload="print()">
    <div class="row membrete">
        <div class="col-md-8">
            <h3>MEDICIONES DE DIFERENCIALES</h3>
        </div>
        <div class="col-md-4">
            <img src="{{  base_path() . '/images/logo-white.png' }}" width="70px">
        </div>
    </div>
    @php
        $range='FUERA';
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

    <div class="pdf-header">

        <div class="row">
            <div style="width:255px; height:240px;display:inline-block; vertical-align: top; padding: 15px 10px 20px 0;">
                <table class="table table-bordered text-center" style="border-collapse: collapse;">
                    <tr>
                        <td class="med-mini" style="border-bottom: 1px solid #eee!important;"><b>Detalle:</b></td>
                        <td class="text-left" style="border-bottom: 1px solid #eee!important;">{{ $value->details }}</td>
                    </tr>
                    <tr>
                        <td class="med-mini"><b>Sector:</b></td>
                        <td class="text-left word-break">{{$value->sector }}</td>
                    </tr>
                </table><br>
                @if($value->image_1)
                    <img src="{{ base_path() . '/images/catalog/'.$value->image_1 }}" style="width: 100%;">
                @else
                    <img src="{{ base_path() . '/images/nophoto.png' }}" style="width: 100%; height: 100%;">
                @endif

                <div style="width:235px; height:30px;padding:10px;margin-top: 15px" class="bordered">
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

           <div style="width:435px; display:inline-block; vertical-align: top; margin-top: 15px; margin-left: 20px;">
                <div class="white-box">
                    <table class="table table-bordered text-center" style="border-collapse: collapse; width:435px;">
                        <tbody>
                            <tr>
                                <td style="text-align:center;border-bottom:1px solid #eee;"><b>Diferencial Nro</b></td>
                                <td style="border-bottom:1px solid #eee;"><b>Valor en ms</b></td>
                                <td style="border-bottom:1px solid #eee;" class="text-left"><b>Observaciones</b></td>
                            </tr>
                            @foreach(json_decode($value->value) as $key => $desc)
                            <tr style=" width:435px;">
                                <td style="text-align:center;border-bottom:1px solid #eee;" class="med-min-little">Diferencial {{ $key + 1 }}</td>
                                <td class="med-min" style="text-align: left;border-bottom:1px solid #eee;padding-top: 15px;">
                                    @if($desc[2] == 'RANGO_1')
                                        <img src="{{ base_path().'/images/R_1.PNG' }}" title="valor normal" style="top:-10px!important; right:-10px;">
                                        <p style="border: 1px solid #8FC239; padding: 5px 10px; display: inline-block;">
                                        @if(isset($desc[3]) && !is_null($desc[3])) {{ $desc[3] }} @else {{ $desc[0] }} ms @endif</p>
                                    @elseif($desc[2] == 'RANGO_2') 
                                        <img src="{{ base_path().'/images/R_2.PNG' }}" title="valor incipiente" style="top:-10px!important;right:-10px;">
                                        <p style="border: 1px solid #8FC239; padding: 5px 10px; display: inline-block;">
                                        @if(isset($desc[3]) && !is_null($desc[3])) {{ $desc[3] }} @else {{ $desc[0] }} ms @endif</p>
                                    @elseif($desc[2] == 'RANGO_3') 
                                        <img src="{{ base_path().'/images/R_3.PNG' }}" title="valor severo" style="top:-10px!important; right:-10px;">
                                        <p style="border: 1px solid #C22034; padding: 5px 10px; display: inline-block;">
                                        @if(isset($desc[3]) && !is_null($desc[3])) {{ $desc[3] }} @else {{ $desc[0] }} ms @endif</p>
                                    @else 
                                        <img src="{{ base_path().'/images/R_3.PNG' }}" title="valor severo" style="top:-10px!important; right:-10px;">
                                        <p style="border: 1px solid #C22034; padding: 5px 10px; display: inline-block;">
                                        @if(isset($desc[3]) && !is_null($desc[3])) {{ $desc[3] }} @else {{ $desc[0] }} ms @endif</p>
                                    @endif
                                </td>
                                <td class="text-left" style="border-bottom:1px solid #eee;">{{ $desc[1] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>