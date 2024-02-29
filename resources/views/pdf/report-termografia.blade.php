<html>
<head>
    <style type="text/css">
        @page{margin-top:40px; margin-left:25px; margin-right:25px; margin-bottom:10px;}
        header{position:fixed; top:0px; left: 20px; right:18px; height:60px;}
        footer{position:fixed; bottom:-35px; left:15px; right:0px; height:60px;}
        body{
            height:800px;
            width: 100%;
            padding:0px 20px;
            font-size: 11px;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        }
        table{
            width: 100%;
            position: relative;           
            border: 1px solid #ddd;
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
            border-left: 1px solid #ddd;
        } 
        .b-r{
            border-right: 1px solid #ddd;
        } 
        .b-t{
            border-top: 1px solid #ddd;
        } 
        .b-b {
            border-bottom: 1px solid #ddd;
        }

        table{
            font-size: 12px;
        }

        td {
            padding: 2px;
        }

        /*tr:nth-child(even) {background-color: #f2f2f2;}*/

        div {
            margin: 0;
            padding: 0;
        }

        h3 {
            font-size: 18px;
            text-align: left;
            color: #fff;
            padding: 5px;
            font-weight: 400;
        }
        h5{
            margin: 0px;
            padding: 0px;
        }
        span{
            font-weight: 500;
        }

        .pdf-header {
            width: 100%;
            margin-bottom: 0px;
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
        hr{
            position: relative;
            border: 2px solid #ba0975;
        }
        .text-center{
            text-align: center;
        }

        .row {
            width: 100%;
            clear: both;
            height: auto;
        }
        .pdf-body {
            width: 100%;
            clear: both;
            height: 300;
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
            padding: 5px 0px;
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
            border: 1px solid #ddd;
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
            background-color: #ddd;
        }
        .border-none{
            border: none;
        }
        .text-uppercase{
            text-transform: uppercase;
        }
        .med-mini{
            width: 50px;
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
            border-right:1px solid #ddd!important;
        }
        .p-img{
            padding: 5px;
            height: 270px;
        }
        h1.SaltoDePagina {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <header>
        <div class="row membrete">
            <div class="col-md-6">
                <h3>ANÁLISIS TERMOGRÁFICO</h3>
            </div>
            <div class="col-md-6">
                <img src="{{  base_path() . '/images/logo-white.png' }}" width="70px">
            </div>
        </div>
    </header>
    <footer>
        <div class="white-box" style="width: 100%;">
            <table class="border-none">
                <tr class="border-none">
                    <td class="w-30">Corrección de la falla</td>
                    <td>Fecha:</td>
                    <td>Firma:</td>
                </tr>
            </table>
        </div>
    </footer>

    @php
        $range='FUERA';
        $bandera = false;
        $i=0;
    @endphp
    @foreach ($valores as $v)
        @if ($bandera == true)
            @php $i=0; $bandera= false; @endphp
            <h1 class="SaltoDePagina"></h1> 
        @endif
        <div class="pdf-header">
            <div class="row">
                <table>
                    <tr>
                        <td class="med-mini back-grey"><b>Fecha:</b></td>
                        <td class="med-mini back-grey">{{ date_format(date_create($medida->date), 'd-m-Y') }}</td>
                        <td class="back-grey b-r-w">Análisis Termográfico nº {{ $v->value_num }}</td>
                        <td class="med-min-little text-center" align="center" rowspan="2">
                            @if($v->criterion == 'Normal')
                                <img src="{{ base_path() . '/images/RANGO_1.png' }}" width="90px">
                                @php $criticidad_name = 'Normal'; @endphp
                            @elseif($v->criterion == 'Regular' || $v->criterion == 'Incipiente')
                                <img src="{{ base_path() . '/images/RANGO_2.png' }}" width="90px">
                                @php $criticidad_name = 'Incipiente'; @endphp
                            @elseif($v->criterion == 'Pronunciado')
                                <img src="{{ base_path() . '/images/RANGO_3.png' }}" width="90px">
                                @php $criticidad_name = 'Pronunciada'; @endphp
                            @elseif($v->criterion == 'Severo')
                                <img src="{{ base_path() . '/images/RANGO_4.png' }}" width="90px">
                                @php $criticidad_name = 'Severa'; @endphp
                            @else
                                @php $criticidad_name = ''; @endphp
                            @endif
                            <br>Criticidad: {{ $criticidad_name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="med-mini"><b>Detalle:</b></td>
                        <td class="med-med b-r-g" colspan="2">{{ $v->title }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row pdf-body">
            <div class="col-md-6 text-center">
                <div class="white-box p-img">
                    @if($v->image_1)
                        <img src="{{ base_path() . '/images/catalog/'.$v->image_1 }}" style="width: 100%; height: 100%;">
                    @else
                        <img src="{{ base_path() . '/images/nophoto.png' }}" style="width: 100%; height: 100%;">
                    @endif
                </div>
                <h5>IMAGEN TERMOGRÁFICA</h5>
            </div>
            <div class="col-md-6 text-center">
                <div class="white-box p-img">
                    @if($v->image_2)
                        <img src="{{ base_path() . '/images/catalog/'.$v->image_2 }}" style="width: 100%; height: 100%;">
                    @else
                        <img src="{{ base_path() . '/images/nophoto.png' }}" style="width: 100%; height: 100%;">
                    @endif
                </div>
                <h5>IMAGEN DIGITAL</h5>
            </div>

            <div class="clearfix"></div>

            <div class="white-box col-md-12">
                <table>
                    <tbody>
                        <tr>
                            <td class="b-r w-30"><b>Observación:</b></td>
                            <td colspan="2">
                                @php
                                    if(strpos($v->recommendation,'[')!==false){
                                        $string=false;
                                        foreach(json_decode($v->recommendation, true) as $obs){
                                           $string .= $obs."\n";
                                        }
                                    }else{
                                        $string=json_decode($v->recommendation);
                                    }
                                @endphp
                                @if ($string)
                                  {{ $string }}
                                @endif
                                <p>{{ $v->other }}</p>
                            </td>
                        </tr>
                        <tr class="back-grey"> 
                            <td class="b-b" colspan="3"><span>Relevamiento visual del tablero </span></td>
                        </tr>
                        <tr>
                            <td class="b-r w-30"><b>Estado del tablero:</b></td>
                            <td class="text-center w-10 b-r">
                                @if($v->state == 'Bueno')
                                    <img src="{{ base_path() . '/images/normal.png' }}" width="30px">
                                @elseif($v->state == 'Regular')
                                    <img src="{{ base_path() . '/images/regular.png' }}" width="30px">
                                @elseif($v->state == 'Malo')
                                    <img src="{{ base_path() . '/images/malo.png' }}" width="30px">
                                @endif
                            </td>
                            <td>
                                @php
                                    if(strpos($v->observation,'[')!==false){
                                        $string=false;
                                        foreach(json_decode($v->observation, true) as $obs){
                                            $string .= $obs."\n";
                                        }
                                    }else{
                                        $string=json_decode($v->observation);
                                    }
                                @endphp
                                {{ $string }}
                            </td>
                        </tr>
                    </tbody>
                </table>   
            </div>
        </div>
        <hr>
       
        @if ($bandera == false && $i==1)
            @php $bandera = true; @endphp
        @endif
        @php $i++; @endphp

    @endforeach
</body>
</html>
