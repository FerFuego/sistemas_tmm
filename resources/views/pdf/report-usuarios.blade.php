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
<body onload="print()">
    <h3 class="box-title m-b-0">LISTADO DE USUARIOS</h3>
          <table>
            <thead>
              <tr>
                <td class="text-center bordered" style="padding-left: 10px; border-right: none;"><b>Usuario</b></td>
                <td class="text-center bordered" style="padding-left: 10px; border-right: none;"><b>Estado de Pago</b></td>
                <td class="text-center bordered" style="padding-left: 10px; border-right: none;"><b>Mediciones</b></td>
                <td class="text-center bordered" style="padding-left: 10px;"><b>Vigencia de medición</b></td>
              </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
              <tr>
                <td class="text-center bordered" style="padding-left: 10px; border-right: none;border-top: none;">{{ $user->name }}</td>
                <td class="text-center bordered" style="padding-left: 10px; border-right: none;border-top: none;">
                    @if($pay != '')
                      @foreach($pay as $pa)
                        @php $ban = false; @endphp
                        @foreach($pa as $p)
                          @if($p['iduser'] == $user->id && $ban == false)
                            @php $class = ''; @endphp
                            @if($p['state'] == 'Al día') @php $class = 'success'; @endphp @endif
                            @if($p['state'] == 'Por vencer') @php $class = 'warning'; @endphp @endif
                            @if($p['state'] == 'Pendiente') @php $class = 'danger'; @endphp @endif
                            <spa class="text-{{ $class }}">{{ $p['state'] }}</span>
                            @php $ban = 1; @endphp
                          @endif
                          @if ($ban == false)
                            <span>No se registran pagos</span>
                          @endif
                        @endforeach
                      @endforeach
                    @else
                      <span>No se registran pagos</span>
                    @endif
                </td>
                <td class="text-center bordered" style="padding-left: 10px; border-right: none;border-top: none;">
                    @foreach ($medidas as $m)
                      @if($m['id'] == $user->id)
                        @if($m['medidas'] != '[]')
                          @foreach($m['medidas'] as $med)
                           {{ $med['type'] }},
                          @endforeach
                        @else
                          No existen mediciones
                        @endif
                      @endif
                    @endforeach
                </td>
                <td class="text-center bordered" style="padding-left: 10px;border-top: none;">
                  @if($validacion != '[]')
                    @php $ban = false; $class = ''; @endphp
                    @foreach($validacion as $v)
                        @if($v['user'] == $user->id && $ban == false)
                            @if($v['validity'] == 'Medición no vigente') @php $class = 'danger'; @endphp @endif
                            @if($v['validity'] == 'En fecha de renovación') @php $class = 'warning'; @endphp @endif
                            @if($v['validity'] == 'Vigente') @php $class = 'success'; @endphp @endif
                            <spa class="text-{{ $class }}">{{ $v['validity'] }}</span>
                            @php $ban = 1; @endphp
                        @endif
                    @endforeach
                    @if ($ban == false)
                      No existen mediciones
                    @endif
                  @else
                      No existen mediciones
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
      </div>
    </body>
</html>