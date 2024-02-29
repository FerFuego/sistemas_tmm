<?php

namespace App\Http\Controllers;

use DB;
use Response;
use App\Range;
use App\State;
use App\RangeValue;
use App\Criticality;
use App\Equivalence;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RangesController extends Controller
{
    public function index($type){


        if($type == 'termografia'){
            $range = Range::where('type', $type)->get();
            $states = State::orderBy('id', 'asc')->get();
            return view('rangos/'.$type)->with('states', $states)
                                        ->with('range', $range);
        }else{
            $range = Range::where('type', $type)->first();
            $critical = Criticality::where('idranges', $range->id)->get();
            $values_cyd = RangeValue::where('idranges', $range->id)->first();
            $values = RangeValue::where('idranges', $range->id)->get();
            $equiv = Equivalence::where('type', $type)->get();
            if($type == 'continuidad' || $type == 'diferencial'){
                $values->pull(0);
            }
            $states = State::orderBy('id', 'asc')->get();
            return view('rangos/'.$type)->with('range', $range)
                                       ->with('values', $values)
                                       ->with('states', $states)
                                       ->with('critical', $critical)
                                       ->with('equivalence', $equiv)
                                       ->with('values_cyd', $values_cyd);
        }
    }

    protected function store(Request $request){

        if(isset($request['nuevo'])){
            $status = $request['nuevo'];
        }else{
            $status = false;
        }

	    $ra = new Range;
	    $ra->type = $request['type'];
	    $ra->description = $request['desc'];
	    $ra->save();

	    $range = Range::where('type', $request['type'])->get();

	    Flash::success("Se ha registrado la descripción");
        return redirect('rangos/'.$request['type'])
                                                    ->with('status', $status)
                                                    ->with('range',$range);
    }

    protected function update(Request $request, $id){
        $ra = Range::findOrFail($id);
        $ra->value_max = $request['value_max'];
        $ra->observation = $request['observation'];
        $ra->recomendation = $request['recomendation'];
        $ra->save();

        $range = Range::where('type', $request['type'])->get();

        Flash::success("Se han registrado los valores máximos");
        return redirect('rangos/'.$request['type'])->with(['range' => $range]);
    }

    protected function updateTermoAjax(Request $request){

        $ra = Range::findOrFail($request['id']);
        $ra->type = $request['type'];
        $ra->description = $request['val'];
        $ra->save();

        return Response::json( array(
            'datos' => $request['val']
        ));
    }

    protected function destroy($id){
        $obj = Range::find($id)->delete();
        return Redirect::back();
    }

}