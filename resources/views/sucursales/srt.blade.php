@extends('layouts.app')

@section('title-section','MEDICIONES SRT')

@section('breadcrumbs')
  <ol class="breadcrumb">
    <li>Medición SRT</li>
  </ol>
@endsection

@section('content')

  @foreach($sucursales as $s)
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="white-box">
            <h3>{{ $s->name }}</h3>
            @if (in_array($s->id, $count_srt))
            <div class="panel-group" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading{{ $s->id }}">
                      <h3 class="panel-title text-merge">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $s->id }}" aria-expanded="true" aria-controls="collapse{{ $s->id }}" class="font-bold"></a> 
                          <div class="pull-right text-muted text-center srt">
                            <a href="{!! url('exportSRT/'.$s->id); !!}">
                              <div class="rounded-circle rounded-circle-tmm2 text-muted fix-22">
                                <i class="icon-cloud-download text-merge" aria-hidden="true"></i>
                              </div>
                            </a>
                        </div>
                        <b>INFORMES 2018 SRT 900/2015</b> 
                      </h3> 
                  </div>
                  <div id="collapse{{ $s->id }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{ $s->id }}">
                      <table class="table table-bordered text-center">
                        <tbody id="parrafo{{ $s->id }}">
                          <tr> 
                            <td class="text-center"><b>Fecha</b></td>
                            <td class="text-center"><b>Medición</b></td>
                            <td class="text-center"><b>Nivel de Criticidad General</b></td>
                            <td class="text-center"><b>Vigencia</b></td>
                            <td class="text-center"></td>
                          </tr>
                          @foreach($medidas as $m)
                            @if($s->id == $m->idbranch_office)
                              <tr>
                                <td class="text-center">{{ date_format(date_create($m->date), 'd-m-Y') }}</td>
                                <td class="text-capitalize text-center"">
                                  @if ($m->type == 'diferencial')
                                    Diferenciales
                                  @else
                                    {{ $m->type }}
                                  @endif
                                </td>
                                <td class="text-center">
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
                                <td  class="text-center">
                                  @foreach($vigencia as $v)
                                    @if($v['id'] == $m->id)
                                      <span class="{{ $v['class'] }}">{{ $v['vigencia'] }}</span>
                                    @endif
                                  @endforeach 
                                </td>
                                <td  class="text-center">
                                  <a href="{!! route('sucursal.show', [$m->idbranch_office, $m->type, $m->id]); !!}" class="fa-link-tmm text-merge">ver</a>
                                </td>
                              </tr>
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                  </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    @endforeach

@endsection 

@section('javascript')
  <script type="text/javascript">
    function mostrar(id){
        $("#"+id).toggle(500);
    }
  </script>
@stop