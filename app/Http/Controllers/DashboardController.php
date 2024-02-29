<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use DateTime; 
use Response;
use App\User;
use App\Value;
use App\Range;
use App\State;
use App\Alarm;
use App\Banner;
use App\Report;
use App\Payment;
use App\Measurement;
use App\BranchOffice;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function index(){
        $user = User::findOrFail(Auth::id());
        $branch = $user->BranchOfficeUnion()->get();
        if($branch !='[]'){
            $meas = $user->MeasurementUnion()->get();

            $mediciones = DB::table('users')
                                ->join('branch_offices', 'branch_offices.idusers', '=', 'users.id')
                                ->join('measurements as m', 'branch_offices.id', '=', 'm.idbranch_office')
                                ->select('users.*', 'branch_offices.*', 'm.*')
                                ->where('users.id', '=', Auth::id())
                                ->whereNull('m.deleted_at')
                                ->orderBy('m.date', 'desc')
                                ->limit(5)
                                ->get();

            $banner = $user->userUnion()->get();

            /*-- nuevo calculo pat--*/
            $pp = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','pat')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $puestatierra = $this->criticidadUltimaMedicionPat($pp);

            /*-- nuevo calculo continuidad--*/
            $cc = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','continuidad')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $continuidad = $this->criticidadUltimaMedicionContinuidad($cc);

            /*-- nuevo calculo diferencial--*/
            $dd = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','diferencial')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $diferencial = $this->criticidadUltimaMedicionDiferencial($dd);

            /*-- nuevo calculo termografia--*/
            $tt = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','termografia')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $termografia = $this->criticidadUltimaMedicionTermografia($tt);

            /*-- Calculo final --*/
            $criticalGral = $this->getCriticidadGral($branch, $puestatierra, $continuidad, $diferencial, $termografia);

            $values = $this->getTotalValues($meas);
            $alarms = $this->getAlarms($meas);
            $report = $this->getReportes($meas);
            $payment = Payment::where('iduser', Auth::id())->get()->last();
        }else{
            $meas = '[]';
            $values = false;
            $alarms = false;
            $report = false;
            $banner = false;
            $payment = false;
            $mediciones = false;
            $criticalGral = false;
        }
        return view('users.dashboard')
                                    ->with('user', $user)
                                    ->with('branch', $branch)
                                    ->with('medidas', $meas)
                                    ->with('total', $values)
                                    ->with('alarms', $alarms)
                                    ->with('report', $report)
                                    ->with('banner', $banner)
                                    ->with('payment', $payment)
                                    ->with('mediciones', $mediciones)
                                    ->with('criticidad', $criticalGral);
    }
    
    protected function getTotalValues($meas){
        $total = 0;

        foreach ($meas as $m) {
            $m = Measurement::findOrFail($m->id);
            $va = $m->ValueUnion()->count();
            $total = $total + $va;
        }

        return $total;
    }

    protected function criticidadUltimaMedicionDiferencial($dd){
        $crit = [];
        /*-- Obtengo el maximo valor de rangos value para el maximo de criticidad --*/
        $ra = Range::where('type', 'diferencial')->firstOrFail();
        $maximos = $ra->RangeValueUnion()->get();
        $max = $maximos->pop();

        foreach ($dd as $va) {
            
            $class = ''; 
            $prom = 0;
            $total=0;
            $i=0; 
            $x=0;
            $x1=0;

            $values = Value::where('idmeasurements', $va->idmeasurements)
                            ->whereNull('deleted_at')
                            ->get();


            /*-- Calculo de criticidad --*/
            foreach ($values as $v) {
                $x=0;
                foreach(json_decode($v->value, true) as $a){
                    if($x < $a[0]){
                        $x = floatval($a[0]);
                    }
                }
                $x1 = $x1 + $x;
                $i++;
            }

            if($i != 0){
                $total = ($x1 / $i);
            }

            if($max->until != 0){
                $prom = ($total * 100) / $max->until;
                $maxim = $max->until;
            }else{
                $prom = 0;
                $maxim = 0;
            }
            /*-- Calculo de color --*/
            if($prom <= 40){ $class = 'success';}
            if($prom > 40 && $prom < 70){  $class = 'warning'; }
            if($prom >= 70){ $class = 'danger'; }
            if($prom > 100){ $total =100; $class = 'danger'; }


            $crit[] =  [
                        'id'=>$va->idmeasurements, 
                        'criticidad'=>$prom, 
                        'branch'=>$va->idbranch_office, 
                        'maxim'=>$maxim,
                        'class'=>$class
                    ];

        }
        return $crit;
    }

    protected function criticidadUltimaMedicionContinuidad($cc){
        $crit = [];
        /*-- Obtengo el maximo valor de rangos value para el maximo de criticidad --*/
        $ra = Range::where('type', 'continuidad')->firstOrFail();
        $maximos = $ra->RangeValueUnion()->get();
        $max = $maximos->pop();

        foreach ($cc as $va) {

            $class = ''; 
            $prom = 0;
            $total=0;
            $i=0; 
            $x=0;
            $x1=0;

            $values = Value::where('idmeasurements', $va->idmeasurements)
                            ->whereNull('deleted_at')
                            ->get();


            /*-- Calculo de criticidad --*/
            foreach ($values as $v) {
                $x=0;
                foreach(json_decode($v->value, true) as $a){
                    if($x < $a[0]){
                        $x = floatval($a[0]);
                    }
                }
                $x1 = $x1 + $x;
                $i++;
            }

            if($i != 0){
                $total = ($x1 / $i);
            }

            if($max->until != 0){
                $prom = ($total * 100) / $max->until;
                $maxim = $max->until;
            }else{
                $prom = 0;
                $maxim = 0;
            }
            /*-- Calculo de color --*/
            if($prom <= 40){ $class = 'success';}
            if($prom > 40 && $prom < 70){  $class = 'warning'; }
            if($prom >= 70){ $class = 'danger'; }
            if($prom > 100){ $total =100; $class = 'danger'; }


            $crit[] =  [
                        'id'=>$va->idmeasurements, 
                        'criticidad'=>$prom, 
                        'branch'=>$va->idbranch_office, 
                        'maxim'=>$maxim,
                        'class'=>$class
                    ];

        }
        return $crit;
    }

    protected function criticidadUltimaMedicionPat($pp){
        $result = [];

        /*-- Agregado 28/03 --*/
        $ra = Range::where('type', 'pat')->firstOrFail();
        $maximos = $ra->RangeValueUnion()->get();
        $max = $maximos->pop();
        /*---*/

        foreach ($pp as $va) {
            $values = Value::where('idmeasurements', $va->idmeasurements)
                            ->whereNull('deleted_at')
                            ->get();

            $total = 0;  
            $class = '';
            $suma = 0;
            $i=0;

            foreach ($values as $v) {
                $suma = $suma + $v->value;
                $i++;
            }
            $criticidad = $suma / $i;
            $total = ($criticidad * 100) / $max->until;


            if($total <= 40){ $class = 'success'; }
            if($total > 40 && $total < 70){ $class = 'warning'; }
            if($total >= 70){ $class = 'danger'; }
            if($total > 100){ $total = 100; $class = 'danger'; }

            $result[] = [
                    'id'=>$va->idmeasurements,
                    'id_branch' =>$va->idbranch_office,
                    'criterion'=>$total,
                    'class'=>$class,
                    'maxim'=> $max->until
                ];
        }
        return $result;
    }

    protected function criticidadUltimaMedicionTermografia($tt){
        $termo = [];
        foreach ($tt as $va) {
            $values = Value::where('idmeasurements', $va->idmeasurements)
                            ->whereNull('deleted_at')
                            ->get();
            $i=0;
            $total=0;
            $subtotal=0;
            foreach ($values as $v) {
                if($v->criterion == 'Normal'){
                  $crit = 5;
                }elseif($v->criterion == 'Incipiente'){
                  $crit = 40;
                }elseif($v->criterion == 'Pronunciado'){
                  $crit = 60;
                }elseif($v->criterion == 'Severo'){
                  $crit = 100;
                }else{
                  $crit = 0;
                }
                $i++;
                $subtotal = $crit + $subtotal;

                if($i != 0){
                    $total = $subtotal / $i;
                }

                if($total <= 40){ $class = 'success'; }
                if($total > 40 && $total < 70){ $class = 'warning'; }
                if($total >= 70){ $class = 'danger'; }
                if($total >= 100){ $total = 100; $class = 'danger'; }

            }//endforeach v

            $termo[] = [
                        'id'=>$va->idmeasurements,
                        'id_branch'=>$va->idbranch_office,
                        'criterion'=>$total,
                        'class'=>$class
                    ];
        }
        return $termo;
    }

    protected function criticidadCyD($meas, $json){

        $maxim = 100;
        $crit = [];

        if($meas != []){
            foreach($meas as $m){
                $class = ''; 
                $prom = 0;
                $total=0;
                $i=0; 
                $x=0;
                $x1=0;

                /*-- Obtengo el maximo valor de rangos value para el maximo de criticidad --*/
                $ra = Range::where('type', $m->type)->firstOrFail();
                $maximos = $ra->RangeValueUnion()->get();
                $max = $maximos->pop();

                /*-- Calculo de criticidad --*/
                if($m->type == 'continuidad' || $m->type == 'diferencial'){
                    foreach(json_decode($json, true) as $a){
                        $x=0;
                        if($m->id === $a['idmeasurements']){
                            foreach(json_decode($a['value'], true) as $v){
                                if($x < $v[0]){
                                    $x = floatval($v[0]);
                                }
                            }
                            $x1 = $x1 + $x;
                            $i++;
                        }
                    }

                    if($i!=0){
                        $total = ($x1 / $i);
                    }

                    if($max->until != 0){
                        $prom = ($total * 100) / $max->until;
                        $maxim = $max->until;
                     }else{
                        $prom = 0;
                        $maxim = 0;
                     }

                    /*-- Calculo de color --*/
                    if($prom <= 40){ $class = 'success';}
                    if($prom > 40 && $prom < 70){  $class = 'warning'; }
                    if($prom >= 70){ $class = 'danger'; }
                    if($prom > 100){ $total =100; $class = 'danger'; }


                    $crit[] =  [
                                'id'=>$m->id, 
                                'criticidad'=>$prom, 
                                'branch'=>$m->idbranch_office, 
                                'maxim'=>$maxim,
                                'class'=>$class
                            ];
                }
            }
        }
        return $crit;
    }

    protected function criticidadTermo($meas){
        $termo = [];

        if($meas != []){
            foreach($meas as $m){
                $i = 0; 
                $subtotal = 0; 
                $total = 0; 
                $class = '';

                if($m->type == 'termografia'){
                    $values = Value::where('idmeasurements', $m->id)->whereNull('deleted_at')->get();
                    foreach ($values as $v) {
                        if($v->criterion == 'Normal'){
                          $crit = 5;
                        }elseif($v->criterion == 'Incipiente'){
                          $crit = 40;
                        }elseif($v->criterion == 'Pronunciado'){
                          $crit = 60;
                        }elseif($v->criterion == 'Severo'){
                          $crit = 100;
                        }else{
                          $crit = 0;
                        }
                        $i++;
                        $subtotal = $crit + $subtotal;

                        if($i != 0){
                            $total = $subtotal / $i;
                        }

                        if($total <= 40){ $class = 'success'; }
                        if($total > 40 && $total < 70){ $class = 'warning'; }
                        if($total >= 70){ $class = 'danger'; }
                        if($total >= 100){ $total = 100; $class = 'danger'; }

                    }//endforeach v

                    $termo[] = [
                                'id'=>$m->id,
                                'id_branch'=>$m->idbranch_office,
                                'criterion'=>$total,
                                'class'=>$class
                            ];
                }//endif

            }//enforeach t
        }
        return $termo;
    }

    protected function criticidadPAT($pat){ 
        $result = [];

        /*-- Agregado 28/03 --*/
        $ra = Range::where('type', 'pat')->firstOrFail();
        $maximos = $ra->RangeValueUnion()->get();
        $max = $maximos->pop();
        /*---*/

        if($pat != []){
            foreach($pat as $p){
                $maxim = 100;
                $total = 0;  
                $class = '';
                $meas = Measurement::findOrFail($p->idmeasurements);

                $total = ($p->criticidad * 100) / $max->until;

                if($total <= 40){ $class = 'success'; }
                if($total > 40 && $total < 70){ $class = 'warning'; }
                if($total >= 70){ $class = 'danger'; }
                if($total > 100){ $total = 100; $class = 'danger'; }

                $result[] = [
                        'id'=>$meas['id'],
                        'id_branch' =>$meas['idbranch_office'],
                        'criterion'=>$total,
                        'class'=>$class,
                        'maxim'=> $max->until
                    ];
            }//end foreach
        }
        return $result;
    }

    protected function getCriticidadGral($branchoffs, $puestatierra, $continuidad, $diferencial, $termografia){
        $totalfinal = [];

        foreach ($branchoffs as $b) {

            $crit_pat = 0;
            $cant_pat = 0;
            if($puestatierra != []){
                foreach ($puestatierra as $p) {
                   if($p['id_branch'] == $b->id){
                        $crit_pat = $crit_pat + $p['criterion'];
                        $cant_pat++;
                   }
                }
            }

            $crit_c = 0;
            $cant_c = 0;
            if($continuidad != []){
                foreach ($continuidad as $c) {
                   if($c['branch'] == $b->id){
                        $crit_c = $crit_c + $c['criticidad'];
                        $cant_c++;
                   }
                }
            }

            $crit_d = 0;
            $cant_d = 0;
            if($diferencial != []){
                foreach ($diferencial as $d) {
                   if($d['branch'] == $b->id){
                        $crit_d = $crit_d + $d['criticidad'];
                        $cant_d++;
                   }
                }
            }

            $crit_term = 0;
            $cant_term = 0;
            if($termografia != []){
                foreach ($termografia as $t) {
                   if($t['id_branch'] == $b->id){
                        $crit_term = $crit_term + $t['criterion'];
                        $cant_term++;
                   }
                }
            }


            $cant_medidas = $cant_pat + $cant_c + $cant_d  + $cant_term;

            if($cant_medidas > 0){
                $subtotal = ($crit_pat + $crit_c +  $crit_d + $crit_term) / $cant_medidas;
            }else{
                $subtotal = 0; 
            }

            $class = '';
            if($subtotal <= 40){ $class = 'success'; }
            if($subtotal > 40 && $subtotal < 70) { $class = 'warning'; }
            if($subtotal >= 70) { $class = 'danger'; }
            if($subtotal > 100) { $subtotal = 100; $class = 'danger'; }


            $totalfinal[] = array(
                        "criticidad" => $subtotal,
                        "PAT" => $crit_pat,
                        "c_PAT" => $cant_pat,
                        "C" => $crit_c,
                        "c_C" => $cant_c,
                        "D" => $crit_d,
                        "C_D" => $cant_d,
                        "TER" => $crit_term,
                        "c_TER" => $crit_term,
                        "branch" => $b->id,
                        "class" => $class
                    );
        }

     return $totalfinal;
    }

    protected function getAlarms($meas){
        $total = [];

        foreach ($meas as $m) {
            $m = Measurement::findOrFail($m->id);
            $value = $m->ValueUnion()->orderBy('date')->get();
            foreach ($value as $v) {
                $val = Value::findOrFail($v->id);
                $alarm = $val->AlarmtUnion()->where('state','Alerta')->orderBy('date')->first();
                if($alarm){
                    $total[] = array(
                                    'branch'=>$v->idbranch_office,  
                                    'measurements'=> $m->id,
                                    'measurements_date'=>$m->date,
                                    'alarm'=>$alarm
                                );
                }//endif
            }//endforeach $value
        }//enforeach $meas

        usort($total, array( $this, 'ordenar'));

        uasort($total, array( $this, 'comp'));

        return $total;
    }

    public function comp($a, $b){
        return strcmp($a['measurements_date'], $b['measurements_date']);
    }

    public function ordenar($a, $b){
        return strtotime($a['measurements_date']) - strtotime($b['measurements_date']);
    }


    protected function getReportes($meas){
        $total = [];

        foreach ($meas as $m) {
            $m = Measurement::findOrFail($m->id);
            $value = $m->ValueUnion()->get();
            foreach ($value as $v) {
                $rep = Value::findOrFail($v->id);
                $report = $rep->ReportUnion()->first();
                if($report){
                    $total[] = array(
                                    'branch'=>$v->idbranch_office,  
                                    'report'=>$report
                                );
                }//endif
            }
        }

        return $total;
    }

}
