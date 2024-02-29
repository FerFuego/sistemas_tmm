<?php

namespace App\Http\Controllers;

use App\Range;
use App\RangeValue;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RangeValueController extends Controller{

    protected function store(Request $request){

        if(isset($request['nuevo'])){
            $status = $request['nuevo'];
        }else{
            $status = false;
        }

        $val = new RangeValue();
        $val->since = $request['since'];
        $val->until = $request['until'];
        $val->icono = $request['icono'];
        $val->observation = $request['observation'];
        $val->recomendation = json_encode($request['recomendation']);
        $val->idranges = $request['idrange'];
        $val->save();

        Flash::success("Se ha registrado la descripción");
        return redirect('rangos/'.$request['type'])->with('status', $status);
    }

    protected function update(Request $request, $id){

        $val = RangeValue::findOrFail($id);
        $val->since = $request['since'];
        $val->until = $request['until'];
        $val->icono = $request['icono'];
        $val->observation = $request['observation'];
        $val->save();

        Flash::success("Se han registrado los valores");
        return redirect::back();
    }


}
