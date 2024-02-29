<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Value;
use App\Range;
use App\State;
use App\Alarm;
use App\Measurement;
use App\BranchOffice;
use App\Equivalence;
use App\Mail\AlarmaEmail;
use Illuminate\Support\Facades\Mail;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ValueController extends Controller{

    public function show($type, $id){
        $value = Value::find($id);
        $report = $value->ReportUnion()->get();
        $alarm = $value->AlarmtUnion()->whereNotIn('state',['Alerta','Enviado'])->get();
        $meas = Measurement::findOrFail($value->idmeasurements);
        $user = User::findOrFail($meas['idusers']);
        $branch = BranchOffice::findOrFail($meas['idbranch_office']);
        $rango = Range::where('type', $type)->firstOrFail();
        $crit = $rango->CriticalUnion()->first();
        $rangos_valores = $rango->RangeValueUnion()->get();
        $criticidad = $this->CalculoGraficoCriticidad($value, $crit);
        $states = State::where('type', $type)->get();
        return view($type.'.mediciones.show')->with('medida', $meas)
                                             ->with('type', $type)
                                             ->with('user', $user)
                                             ->with('value', $value)
                                             ->with('sucursal', $branch)
                                             ->with('alarmas', $alarm)
                                             ->with('reporte', $report)
                                             ->with('estados', $states)
                                             ->with('criticidad', $criticidad)
                                             ->with('rangos_valores', $rangos_valores);
    }

    protected function CalculoGraficoCriticidad($v, $c){
        $criticidad = 0;
        $rango = 0;
        $result = [];

        switch ($v->type) {
            case 'pat':
                if ($v->value >= $c->since_1 && $v->value <= $c->until_1){
                    $criticidad = $c->observation_1;
                    $rango = 'RANGO_1';
                }elseif ($v->value >= $c->since_2 && $v->value <= $c->until_2){
                    $criticidad = $c->observation_2;
                    $rango = 'RANGO_2';
                }elseif ($v->value >= $c->since_3 && $v->value <= $c->until_3){
                    $criticidad = $c->observation_3;
                    $rango = 'RANGO_3';
                }elseif ($v->value >= $c->since_4 && $v->value <= $c->until_4){
                    $criticidad = $c->observation_4;
                    $rango = 'RANGO_4';
                }else{
                    $criticidad = $c->observation_4;
                    $rango = 'RANGO_4';
                }
                break;
            case 'continuidad':
             
                $i = 0;
                $val = 0;
                $total = 0;
                foreach (json_decode($v->value, true) as $key => $desc){
                    if($total < $desc[0]){
                        $total = $desc[0];
                    }
                    $i++;
                }    

                if ($total >= $c->since_1 && $total <= $c->until_1){
                    $criticidad = $c->observation_1;
                    $rango = 'RANGO_1';
                }elseif ($total >= $c->since_2 && $total <= $c->until_2){
                    $criticidad = $c->observation_2;
                    $rango = 'RANGO_2';
                }elseif ($total >= $c->since_3 && $total <= $c->until_3){
                    $criticidad = $c->observation_3;
                    $rango = 'RANGO_3';
                }elseif ($total >= $c->since_4 && $total <= $c->until_4){
                    $criticidad = $c->observation_4;
                    $rango = 'RANGO_4';
                }else{
                    $criticidad = $c->observation_4;
                    $rango = 'RANGO_4';
                }
                       
                break;
            case 'diferencial':
                    $i = 0;
                    $val = 0;
                    $total = 0;
                    foreach (json_decode($v->value, true) as $key => $desc){
                        if($total < $desc[0]){
                            $total = $desc[0];
                        }
                        $i++;
                    }  

                    if ($total >= $c->since_1 && $total <= $c->until_1){
                        $criticidad = $c->observation_1;
                        $rango = 'RANGO_1';
                    }elseif ($total >= $c->since_2 && $total <= $c->until_2){
                        $criticidad = $c->observation_2;
                        $rango = 'RANGO_2';
                    }elseif ($total >= $c->since_3 && $total <= $c->until_3){
                        $criticidad = $c->observation_3;
                        $rango = 'RANGO_3';
                    }elseif ($total >= $c->since_4 && $total <= $c->until_4){
                        $criticidad = $c->observation_4;
                        $rango = 'RANGO_4';
                    }else{
                        $criticidad = $c->observation_4;
                        $rango = 'RANGO_4';
                    }
                break;
            case 'termografia':
                # code...
                break;
             default:
                # code...
                break;
        }

        return $result = array(
                    'criticidad' => $criticidad,
                    'rango' => $rango,
                );
    }

    protected function store(Request $request){
        $imageName1='';
        $imageName2='';
        $imageName3='';
        $this->validate($request, ['image_1' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048']);
        $this->validate($request, ['image_2' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048']);
        $this->validate($request, ['image_3' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048']);

        if($request['type'] == 'diferencial' or $request['type'] == 'continuidad'){
            for ($i=0; $i < sizeof($request['cant']); $i++) { 
                if(is_numeric($request['cant'][$i])){
                    $puntos[$i] = array($request['cant'][$i], $request['desc'][$i], $request['icono'][$i], $request['equiv'][$i]);
                }else{
                    $puntos[$i] = array($request['equiv'][$i], $request['desc'][$i], $request['icono'][$i], $request['cant'][$i]);
                }
            }
            //construyo un array con los valores de las mediciones
            $request['value'] = json_encode($puntos); 
        }

        if ($request->hasFile('image_1')) {
            $imageName1 = time().'.'.$request->file('image_1')->getClientOriginalExtension();
            $request->file('image_1')->move(base_path().'/images/catalog/', $imageName1);
        }else{
            $imageName1 = $request['image_1_old'];
        }
        if ($request->hasFile('image_2')) {
            $imageName2 = time().'2.'.$request->file('image_2')->getClientOriginalExtension();
            $request->file('image_2')->move(base_path().'/images/catalog/', $imageName2);
        }else{
            $imageName2 = $request['image_2_old'];
        }
        if ($request->hasFile('image_3')) {
            $imageName3 = time().'3.'.$request->file('image_3')->getClientOriginalExtension();
            $request->file('image_3')->move(base_path().'/images/catalog/', $imageName3);
        }else{
            $imageName3 = $request['image_3_old'];
        }

        if($request['type'] == 'pat'){
            $equiv = Equivalence::where('code', $request['value'])->where('type', $request['type'])->first();
        }

        $value = new Value();
        $value->date = date('Y-m-j');
        $value->title = $request['title'];
        $value->value_num = $request['value_num'];
        $value->value_max = $request['value_max'];

        if($request['type'] == 'pat'){
            $value->value = (is_numeric($request['value'])) ? $request['value'] : $equiv->value;
        }else{
            $value->value = $request['value'];
        }

        if($request['type'] == 'pat'){
            $value->equivalence = (!is_numeric($request['value'])) ? $request['value'] : null;
        }else{
            $value->equivalence = null;
        }

        $value->type = $request['type'];
        $value->state = $request['state'];
        $value->sector = $request['sector'];
        $value->details = $request['detalles'];
        $value->reparation = $request['reparation'];
        $value->criterion = $request['criterion'];
        $value->observation = json_encode($request['observation']);
        $value->recommendation = json_encode($request['recomendation']);
        $value->other = $request['other'];
        $value->image_1 = $imageName1;
        $value->image_2 = $imageName2;
        $value->image_3 = $imageName3;
        $value->idmeasurements = $request['idmeasurement'];
        $value->idbranch_office = $request['idbranch'];
        $value->save();

        //envia la variable para cargar nueva medicion
        if(isset($request['nuevo'])){
            $status = $request['nuevo'];
        }else{
            $status = false;
        }

        // Verifico la criticidad para la alarma
        $alarma = $this->verify_crit_value($value);

        if($alarma == 'Alarma creada'){
            Flash::success("Se ha registrado la medición y se creo una alarma.");
        }else{
            Flash::success("Se ha registrado la medición");
        }

        return Redirect::back()->with('status', $status);
    }

    protected function update(Request $request, $id){
        $imageName1='';
        $imageName2='';
        $imageName3='';
        $this->validate($request, ['image_1' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048']);
        $this->validate($request, ['image_2' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048']);
        $this->validate($request, ['image_3' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048']);

        if(($request['type'] == 'diferencial' or $request['type'] == 'continuidad')  && $request['cant']){
            for ($i=0; $i < sizeof($request['cant']); $i++) { 
                if(is_numeric($request['cant'][$i])){
                    $puntos[$i] = array($request['cant'][$i], $request['desc'][$i], $request['icono'][$i], $request['equiv'][$i]);
                }else{
                    $puntos[$i] = array($request['equiv'][$i], $request['desc'][$i], $request['icono'][$i], $request['cant'][$i]);
                }
            }
            //construyo un array con los valores de las mediciones
            $request['value'] = json_encode($puntos); 
        }

        if ($request->hasFile('image_1')) {
            $imageName1 = time().'.'.$request->file('image_1')->getClientOriginalExtension();
            $request->file('image_1')->move(base_path().'/images/catalog/', $imageName1);
        }else{
            $imageName1 = $request['image_1_old'];
        }
        if ($request->hasFile('image_2')) {
            $imageName2 = time().'2.'.$request->file('image_2')->getClientOriginalExtension();
            $request->file('image_2')->move(base_path().'/images/catalog/', $imageName2);
        }else{
            $imageName2 = $request['image_2_old'];
        }
        if ($request->hasFile('image_3')) {
            $imageName3 = time().'3.'.$request->file('image_3')->getClientOriginalExtension();
            $request->file('image_3')->move(base_path().'/images/catalog/', $imageName3);
        }else{
            $imageName3 = $request['image_3_old'];
        }

        if($request['type'] == 'pat'){
            $equiv = Equivalence::where('code', $request['value'])->where('type', $request['type'])->first();
        }

        $value = Value::findOrFail($id);
        $value->date = date('Y-m-j');
        $value->title = $request['title'];
        $value->value_num = $request['value_num'];
        $value->value_max = $request['value_max'];

       if($request['type'] == 'pat'){
            $value->value = (is_numeric($request['value'])) ? $request['value'] : $equiv->value;
        }else{
            $value->value = $request['value'];
        }

        if($request['type'] == 'pat'){
            $value->equivalence = (!is_numeric($request['value'])) ? $request['value'] : null;
        }else{
            $value->equivalence = null;
        }
        
        $value->type = $request['type'];
        $value->state = $request['state'];
        $value->sector = $request['sector'];
        $value->details = $request['detalles'];
        $value->reparation = $request['reparation'];
        $value->criterion = $request['criterion'];
        $value->observation = json_encode($request['observation']);
        $value->recommendation = json_encode($request['recomendation']);
        $value->other = $request['other'];
        $value->image_1 = $imageName1;
        $value->image_2 = $imageName2;
        $value->image_3 = $imageName3;
        $value->save();

        Flash::success("Se han guardado los cambios de la medición");
        return Redirect::back();
    }

    public function exportMedition($type, $id){

        $value = Value::findOrFail($id);
        $report = $value->ReportUnion()->get();
        $alarm = $value->AlarmtUnion()->get();
        $meas = Measurement::findOrFail($value->idmeasurements);
        $user = User::findOrFail($meas['idusers']);
        $branch = BranchOffice::findOrFail($meas['idbranch_office']);
        $rango = Range::where('type', $type)->firstOrFail();
        $crit = $rango->CriticalUnion()->first();
        $rangos_valores = $rango->RangeValueUnion()->get();
        $criticidad = $this->CalculoGraficoCriticidad($value, $crit);
        $states = State::where('type', $type)->get();
        $pdf= PDF::loadview('pdf.medicion-'.$type, [
                                            'medida' => $meas,
                                            'type' => $type,
                                            'user' => $user,
                                            'value' => $value,
                                            'sucursal' => $branch,
                                            'alarmas' => $alarm,
                                            'reporte' => $report,
                                            'estados' => $states,
                                            'criticidad' => $criticidad,
                                            'rangos_valores'=> $rangos_valores
                                        ]);

        return $pdf->download('archivo.pdf');
    }

    public function printMedition($type, $id){

        $value = Value::find($id);
        $report = $value->ReportUnion()->get();
        $alarm = $value->AlarmtUnion()->get();
        $meas = Measurement::findOrFail($value->idmeasurements);
        $user = User::findOrFail($meas['idusers']);
        $branch = BranchOffice::findOrFail($meas['idbranch_office']);
        $rango = Range::where('type', $type)->firstOrFail();
        $crit = $rango->CriticalUnion()->first();
        $rangos_valores = $rango->RangeValueUnion()->get();
        $criticidad = $this->CalculoGraficoCriticidad($value, $crit);
        $states = State::where('type', $type)->get();
        return view('pdf.print-'.$type)->with('medida', $meas)
                                             ->with('type', $type)
                                             ->with('user', $user)
                                             ->with('value', $value)
                                             ->with('sucursal', $branch)
                                             ->with('alarmas', $alarm)
                                             ->with('reporte', $report)
                                             ->with('estados', $states)
                                             ->with('criticidad', $criticidad)
                                             ->with('rangos_valores', $rangos_valores);
    }

    protected function verify_crit_value($value){
        $alarma = 'No hay alarmas';
        $range = Range::where('type',$value->type)->first();

        if($range != '[]'){
            $criticidad = $range->CriticalUnion()->get();

            switch ($value->type) {
                case 'pat':
                    if($value->value >= $criticidad[0]->since_4){
                        $alarma = $this->create_alarm($value);
                    }
                break;

                case 'continuidad':
                    $i = 0;
                    $val = 0; 
                    $total = 0;
                    foreach (json_decode($value->value, true) as $key => $desc){
                        if($total < $desc[0]){
                            $total = $desc[0];
                        }
                    }
                        
                    if($total >= $criticidad[0]->since_4){
                        $alarma = $this->create_alarm($value);
                    }
                break;

                case 'diferencial':
                    $i = 0;
                    $val = 0; 
                    $total = 0;
                    foreach (json_decode($value->value, true) as $key => $desc){
                        if($total < $desc[0]){
                            $total = $desc[0];
                        }
                    }
                        
                    if($total >= $criticidad[0]->since_4){
                        $alarma = $this->create_alarm($value);
                    }
                break;

                case 'termografia':
                    if($value->criterion == 'Severo'){
                        $alarma = $this->create_alarm($value);
                    }
                break;
                
                default:
                break;
            }
        }

        return $alarma;
    }

    protected function create_alarm($value){

        $r = new Alarm();
        $r->date = $value->date;
        $r->type = $value->type;
        $r->title = 'La criticidad de la medición '.$value->type.' es severa.';
        $r->detail = 'La criticidad de la medición '.$value->type.' es severa. La medida '.$value->id.' '.$value->title.' presenta valores de criticidad severos, ponga atensión en las recomendaciones que detallamos en el analisis de dicha medida.';
        $r->state = 'Alerta';
        $r->name = '';
        $r->email = '';
        $r->idvalues = $value->id;
        $r->save();

        // $data = [
        //     'user' => 'fer', 
        //     'message' => 'mensaje de prueba', 
        //     'title' => 'probando emails', 
        //     'link' => 'link de la publicaciones'
        // ];
        // Mail::to('ferc_vcp@hotmail.com')->send(new AlarmaEmail($data));

        $alarma = 'Alarma creada';

        return $alarma;
    }

}