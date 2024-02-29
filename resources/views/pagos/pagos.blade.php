@extends('layouts.app')

@section('title-section','PAGOS')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li class="active">Pagos</li>
  </ol>
@endsection

@section('content')
    <div class="white-box">
    	 <h3 class="box-title m-b-0">LISTADO DE PAGOS</h3><hr>
        <table class="table table-bordered">
          <form method="POST" action="{{ url('/pagos/new') }}" id="formPagos">
            {{ csrf_field() }}
          <thead>
            <tr>
              <th scope="col">
                {{ Form::label('usuario') }}
                <select name="iduser" class="form-control">
                  @if($usuarios != '[]')
                    @foreach($usuarios as $us)
                      <option value="{{ $us->id }}">{{ $us->name }}</option>
                    @endforeach
                  @endif
                </select>
              </th>
              <th scope="col">
                {{ Form::label('Estado del pago') }}
                <select name="state" class="form-control" id="state" required>
                  <option value=""></option>
                  <option value="Al día">Al día</option>
                  <option value="Por vencer">Por vencer</option>
                  <option value="Pendiente">Pendiente</option>
                </select>
              </th>
              <th scope="col">
                {{ Form::label('Fecha último pago') }}
                {{ Form::date('date_pay', null, ['class'=>'form-control','id'=>'date_pay','required'=>'required']) }}
              </th>
              <th scope="col">
                {{ Form::label('Fecha siguiente pago') }}
                {{ Form::date('date_next_pay', null, ['class'=>'form-control','id'=>'date_next_pay','required'=>'required']) }}
              </th>
              <th scope="col"  class="text-center">
                <button class="btn btn-default btn-custom-tmm btn-custom-tmm-active" style="margin: 15px 10px;" onclick="enviar()">Guardar Pago</button>
              </th>
            </tr>
          </thead>
          {{ Form::close() }}
          <tbody>
            @if($pagos != '[]')
              @foreach($pagos as $p)
              <tr>
                <th scope="row">
                  @if($usuarios != '[]')
                    @foreach($usuarios as $us)
                      @if($p->iduser == $us->id)
                        {{ $us->name }}
                      @endif
                    @endforeach
                  @endif
                </th>
                <td>
                  @php $class = ''; @endphp
                  @if($p->state == 'Al día') @php $class = 'success'; @endphp @endif
                  @if($p->state == 'Por vencer') @php $class = 'warning'; @endphp @endif
                  @if($p->state == 'Pendiente') @php $class = 'danger'; @endphp @endif
                  <spa class="text-{{ $class }}">{{ $p->state }}</span>
                </td>
                <td>{{ date_format(date_create($p->date_pay), 'd-m-Y') }}</td>
                <td>{{ date_format(date_create($p->date_next_pay ), 'd-m-Y') }}</td>
                <td class="text-center">
                    <a href="{!! route('/pagos/email', [$p->id]); !!}" class="fa-link-tmm text-muted"><i class="icon-bell" style="font-size:18px"></i></a>
                    <a href="{!! route('/pagos/delete', [$p->id]); !!}" class="fa-link-tmm text-danger"><i class="icon-trash"></i></a>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
    </div>
@endsection 
@section('javascript')
<script type="text/javascript">
  function enviar(){
    state = document.getElementById("state").value;
    date_pay = document.getElementById("date_pay").value;
    date_next_pay = document.getElementById("date_next_pay").value;

    if(state == '' || date_pay ==  '' || date_next_pay == ''){
      alert('Completa todos los campos');
    }else{
      $('#formPagos').submit();
    }
  }
</script>
@stop
