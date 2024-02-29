<?php

namespace App\Http\Controllers;

use App\Equivalence;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
class EquivalenceController extends Controller
{
    protected function store(Request $request){

        if(isset($request['nuevo'])){
            $status = $request['nuevo'];
        }else{
            $status = false;
        }

	    $equiv = new Equivalence();
	    $equiv->code = $request['code'];
	    $equiv->value = $request['value'];
	    $equiv->type = $request['type'];
        $equiv->observation = $request['observation'];
        $equiv->recommendation = (isset($request['recommendation'])) ? $request['recommendation'] : null;
	    $equiv->save();

	    $equiv = Equivalence::where('type', $request['type'])->get();

	    Flash::success("Se ha registrado la equivalencia");
        return redirect('rangos/'.$request['type'])
                ->with('status', $status)
                ->with('equivalences',$equiv);
    }
}
