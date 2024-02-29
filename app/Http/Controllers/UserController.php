<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use DateTime;
use App\User;
use App\Role;
use App\Range;
use App\Value;
use App\Payment;
use App\Validity;
use App\Measurement;
use App\BranchOffice;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{

    public function index(){

        $users = User::orderBy('id', 'ASC')->paginate(10);
        $locks = DB::table('users')->where('lock', 'bloqueado')->whereNotNull('deleted_at')->orderBy('id', 'ASC')->get();
        $pay = $this->getPayment($users);
        $medidas = $this->getMedidas($users);
        $validity = $this->getValidityMeasurement($users);
        return view('users.all')
                                ->with('pay', $pay)
                                ->with('locks', $locks)
                                ->with('users', $users)
                                ->with('medidas', $medidas)
                                ->with('validacion', $validity);
    }

    protected function getMedidas($users){
        foreach ($users as $u) {
            $meas = Measurement::select(DB::raw('type'))
                                ->where('idusers', $u->id)
                                ->groupBy('type')
                                ->get();
            $total[] = [
                        'id'=> $u->id,
                        'medidas' => $meas
                        ];
        }
        return $total;
    }

    protected function getValidityMeasurement($users){
        $total = [];
        foreach($users as $u){
            $meas = Measurement::where('idusers', $u->id)
                                ->orderBy('date', 'asc')
                                ->get();
            foreach ($meas as $m) {

                $validity = Validity::where('type', $m->type)->get();
                $date1 = new DateTime($m->date);
                $date2 = new DateTime("now");
                $interval = $date1->diff($date2);
                $years = $interval->format('%y');
                $months = $interval->format('%m');
                $days = $interval->format('%d');
                if((int)$years > 0 && !$this->tieneMedicionVigente($m, $meas)){

                        $total[] = [
                                    'user' => $u->id,
                                    'type' => $m->type,
                                    'date' => $m->date,
                                    'years' => $years,
                                    'months' => $months,
                                    'validity' => 'Medición no vigente'
                                    ];
                }else{
                    foreach($validity as $v) {
                        if($months >= $v->since && $months <= $v->until){
                            $total[] = [
                                    'user' => $u->id,
                                    'type' => $v->type,
                                    'date' => $m->date,
                                    'years' => $years,
                                    'months' => $months,
                                    'validity' => $v->state
                                    ];
                        }//endif
                    }//endforeach v
                }//endif
            }//endforeach m
        }//endforeach u

        return $total;
    }

    /**
     * @function noTieneMedicionVigente
     *
     * @param $measurementItem | Item a comparar
     * @param $measurementList | Listado de mediciones para comparar con el item
     *
     * @return true/false Si tiene otra medicion vigente o no
     *
     * Mendo
     */
    protected function tieneMedicionVigente($measurementItem, $measurementList) {
        foreach ($measurementList as $m) {
            $date1 = new DateTime($m->date);
            $date2 = new DateTime("now");
            $interval = $date1->diff($date2);
            $years = $interval->format('%y');
            if (
                $m->place == $measurementItem->place && // Si es en la misma sucursal
                $m->type == $measurementItem->type &&   // Y es el mismo tipo
                (int)$years <= 0       // Y la fecha es mas cercana a la actual
                ) {
                return true; // Entonces tiene otra medicion vigente
            }
        }

        // Si ya recorri la lista y no encontre otro valor mas reciente neen la misma sucursal y tipo,
        // entonces no tiene otra medicion vigente
        return false;
    }

    protected function getPayment($users){
        $total = [];
        foreach ($users as $u) {

            $pay = $u->PaymentsUnion()->orderBy('created_at', 'DESC')->take(1)->get();
            
            if($pay != '[]'){
                $total[] = $pay;
            }
        }

        return $total;
    }

    public function show($id){

        $users = User::findOrFail($id);
        $branchoffs = $users->BranchOfficeUnion()->get();
        if($branchoffs != '[]'){
            $meas = $users->MeasurementUnion()->get();

            $count = DB::table('measurements')
                                 ->select(DB::raw('count(*) as num, type'))
                                 ->where('idusers', '=', $id)
                                 ->whereNull('deleted_at')
                                 ->groupBy('type')
                                 ->get();

            $mediciones = DB::table('users')
                                ->join('branch_offices', 'branch_offices.idusers', '=', 'users.id')
                                ->join('measurements as m', 'branch_offices.id', '=', 'm.idbranch_office')
                                ->select('users.*', 'branch_offices.*', 'm.*')
                                ->where('users.id', '=', $id)
                                ->whereNull('m.deleted_at')
                                ->orderBy('m.id', 'desc')
                                ->limit(5)
                                ->get();

            /*-- calculo pat criticidad ultimas mediciones--*/
            $pat = DB::table('values as v')
                    ->select(DB::raw('count(v.value) as cant, sum(v.value) as suma, v.idmeasurements, sum(v.value) div count(v.value) as criticidad'))
                    ->where('v.type', 'pat')
                    ->join('measurements as m', 'v.idmeasurements', '=', 'm.id')
                    ->whereNull('m.deleted_at')
                    ->groupBy('v.idmeasurements')
                    ->get();
            $puestatierra = $this->criticidadPAT($pat);

            //valores json para calcular la criticidad continuidad
            $json = DB::table('values as v')
                            ->select(DB::raw('v.idmeasurements, v.value, v.type, v.idbranch_office'))
                            ->join('measurements as m', 'v.idmeasurements', '=', 'm.id')
                            ->whereIn('v.type', ['continuidad','diferencial'])
                            ->whereNull('m.deleted_at')
                            ->get();
            $continuidad = $this->criticidadCyD($meas, $json);

            //valores json para calcular la criticidad diferencial
            $json = DB::table('values as v')
                            ->select(DB::raw('v.idmeasurements, v.value, v.type, v.idbranch_office'))
                            ->join('measurements as m', 'v.idmeasurements', '=', 'm.id')
                            ->whereIn('v.type', ['continuidad','diferencial'])
                            ->whereNull('m.deleted_at')
                            ->get();
            $diferencial = $this->criticidadCyD($meas, $json);
            //criterion para la criticidad de termografia
            $thermo = DB::table('values as v')
                                ->select(DB::raw('v.id, v.type, v.criterion,v.idmeasurements'))
                                ->join('measurements as m', 'v.idmeasurements', '=', 'm.id')
                                ->where('v.idbranch_office', $branchoffs[0]->id)
                                ->where('v.type', 'termografia')
                                ->whereNull('v.deleted_at')
                                ->get();
            $termografia = $this->criticidadTermo($meas);

            /*-- nuevo calculo pat criticidadGral--*/
            $pp = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','pat')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $puestatierraGral = $this->criticidadUltimaMedicionPat($pp);


            /*-- nuevo calculo continuidad--*/
            $cc = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','continuidad')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $continuidadGral = $this->criticidadUltimaMedicionContinuidad($cc);

            /*-- nuevo calculo diferencial--*/
            $dd = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','diferencial')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $diferencialGral = $this->criticidadUltimaMedicionDiferencial($dd);

            /*-- nuevo calculo termografia--*/
            $tt = Value::select(DB::raw('MAX(idmeasurements) as idmeasurements, idbranch_office'))
                        ->where('type','termografia')
                        ->whereNull('deleted_at')
                        ->groupBy('idbranch_office')
                        ->get();
            $termografiaGral = $this->criticidadUltimaMedicionTermografia($tt);
            
            /*-- Calculo final --*/
            $criticalGral = $this->getCriticidadGral($branchoffs, $puestatierraGral, $continuidadGral, $diferencialGral, $termografiaGral);

            $maximos = Range::all();
        }else{
            $count = false;
            $meas = false;
            $json = false;
            $tt = false;
            $cc = false;
            $pp = false;
            $dd = false;
            $continuidad = false;
            $diferencial = false;
            $maximos = false;
            $mediciones = false;
            $criticalGral = false;
            $criticidadCyD = false;
            $puestatierra = false;
            $termografia = false;
        }

        return view('users.show')->with('user', $users)
                                ->with('contador', $count)
                                ->with('maximos', $maximos)
                                ->with('criticidad_json',$cc)
                                ->with('branchoffs', $branchoffs)
                                ->with('mediciones', $mediciones)
                                ->with('termografia', $termografia)
                                ->with('continuidad', $continuidad)
                                ->with('diferencial', $diferencial)
                                ->with('puestatierra', $puestatierra)
                                ->with('criticidadGral',$criticalGral);
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

                           // return $values;
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
            if($prom > 100){ $total = 100; $class = 'danger'; }


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

                /*-- Agregado 05/03 --*/
                $ra = Range::where('type', $m->type)->firstOrFail();
                $maximos = $ra->RangeValueUnion()->get();
                $max = $maximos->pop();
                /*---*/

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

                    /*-- Calculo de promedio --*/
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
                    if($prom > 100){ $prom = 100; $class = 'danger'; }


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
                        if($total > 100){ $total = 100; $class = 'danger'; }

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

    protected function create(UserCreateRequest $request){

        $user = User::create([
            'name' => $request['company'],
            'username' => $request['email'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'company' => $request['company'],
            'mediciones' => 'Pat, Continuidad, Diferencial, Termografía',
            'location' => $request['location'],
            'password' => bcrypt($request['password']),
            'avatar' => 'http://lorempixel/300/300/people?'.random_int(1, 1000)
        ]);

        if($request->rol == 'admin'){
            $user->roles()->attach(Role::where('name', 'admin')->first());
        }else{
            $user->roles()->attach(Role::where('name', 'user')->first());
        }

        Flash::success("Se ha registrado ".$user->name." de forma exitosa!");
        return redirect()->route('usuarios_todos');
    }

    protected function edit($id){

        $users = User::find($id);
        $branchoffs = BranchOffice::where('idusers', '=', $users->id)->orderBy('id', 'ASC')->get();
        return view('users.edit')->with('user', $users)
                                 ->with('branchoffs', $branchoffs);
    }

    protected function update(UserUpdateRequest $request, $id){

        $user = User::find($id);
        $user->name = $request['company'];
        $user->username = $request['email'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->company = $request['company'];
        $user->mediciones = 'Pat, Continuidad, Diferencial, Termografía';
        $user->address = $request['address'];
        $user->location = $request['location'];
        if($request['password'] != ''){
            $user->password = bcrypt($request['password']);
        }else{
            $user->password = $request['old_pass'];
        }

        if($request->rol == 'admin'){
            $user->roles()->updateExistingPivot(2, ['user_id'=>$id,'role_id'=>1]);
        }else{
            $user->roles()->updateExistingPivot(1, ['user_id'=>$id,'role_id'=>2]);
        }
        $user->avatar = 'http://lorempixel/300/300/people?'.random_int(1, 1000);
        $user->save();

        Flash::success("Se ha actualizado el usuario ".$user->name);
        if(Auth::user()->hasRole('admin')){
            return redirect()->route('usuarios_todos');
        }else{
            return Redirect::back();
        }
    }

    protected function updateAvatar(Request $request){

        if ($request->hasFile('avatar')) {
            $archivo = time().'.'.$request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path().'/images/users/', $archivo);
        }

        $user = User::findOrFail($request['idusers']);
        $user->avatar = $archivo;
        $user->save();
        return redirect()->back();
    }

    protected function destroy($id){

        if($id == Auth::id()){
            Flash::error("No puedes eliminar tu propio usuario");
            return redirect()->back();
        }
            $user = User::find($id);
            $meas = $user->MeasurementUnion()->get();
            foreach ($meas as $m) {
                $me = Measurement::find($m->id);
                $values = $me->ValueUnion()->get();
                foreach ($values as $v) {
                    $va = Value::find($v->id)->delete();
                }
                $me->delete();
             }
            $user->lock = '';
            $user->email = $user->email.'.delete.'.time();
            $user->save();
            $user->delete();
            Flash::success("Se ha eliminado el usuario ");
            return redirect()->back();
    }

    protected function lockUser($id){
        $user = User::find($id);
        $user->deleted_at = date('Y-m-j');
        $user->lock = 'bloqueado';
        $user->save();
        Flash::error("Se ha bloqueado al usuario ");
        return redirect()->back();
    }

    protected function unlockUser($id){
        $user = User::withTrashed()->where('id', '=', $id)->first();
        $user->restore();
        Flash::success("Se ha desbloqueado al usuario ");
        return redirect()->back();
    }

    public function exportUsers(){
        $users = User::orderBy('id', 'ASC')->paginate(10);
        $pay = $this->getPayment($users);
        $medidas = $this->getMedidas($users);
        $validity = $this->getValidityMeasurement($users);
        $pdf= PDF::loadview('pdf.report-usuarios', [
                                            'pay'=>$pay,
                                            'users'=>$users,
                                            'medidas'=>$medidas,
                                            'validacion'=>$validity,
                                        ]);
        return $pdf->download('archivo.pdf');
    }

    public function printUsers(){
        $users = User::orderBy('id', 'ASC')->paginate(10);
        $pay = $this->getPayment($users);
        $medidas = $this->getMedidas($users);
        $validity = $this->getValidityMeasurement($users);
        return view('pdf.report-usuarios')
                                ->with('pay', $pay)
                                ->with('users', $users)
                                ->with('medidas', $medidas)
                                ->with('validacion', $validity);
    }
}
