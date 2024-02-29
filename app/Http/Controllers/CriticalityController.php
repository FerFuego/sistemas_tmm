<?php

namespace App\Http\Controllers;

use App\Range;
use App\Criticality;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;

class CriticalityController extends Controller
{

    protected function update(Request $request, $id){

    	$crit = Criticality::findOrFail($id);
	    $crit->since_1 = $request['desde_1'];
	    $crit->since_2 = $request['desde_2'];
	    $crit->since_3 = $request['desde_3'];
	    $crit->since_4 = $request['desde_4'];
	    $crit->until_1 = $request['hasta_1'];
	    $crit->until_2 = $request['hasta_2'];
	    $crit->until_3 = $request['hasta_3'];
	    $crit->until_4 = $request['hasta_4'];
	    $crit->observation_1 = $request['observ_1'];
	    $crit->observation_2 = $request['observ_2'];
	    $crit->observation_3 = $request['observ_3'];
	    $crit->observation_4 = $request['observ_4'];
	    $crit->save();

	    $range = Range::where('type', $request['type'])->get();

	    Flash::success("Se han registrado los valores máximos de criticidad");

        return redirect('rangos/'.$request['type'])->with(['range' => $range]);
    }
}
