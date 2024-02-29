<?php

namespace App\Http\Controllers;

use App\Users;
use App\Value;
use App\Notifiable;
use App\Measurement;
use App\BranchOffice;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BranchOfficeController extends Controller{

    protected function create(Request $request){

     	$branchoffs = BranchOffice::create([
	        'name' => $request['name'],
	        'email' => $request['email'],
	        'phone' => $request['phone'],
	        'address' => $request['address'],
	        'location' => $request['location'],
	        'province' => $request['province'],
	        'pat' => $request['mediciones'],
	        'continuity' => $request['continuity'],
	        'differentials' => $request['differentials'],
	        'thermography' => $request['thermography'],
	        'idusers' => $request['idusers'],
	    ]);

        Flash::success("Se ha registrado la sucursal ".$branchoffs->name);
        return redirect()->route('usuarios.editar', $branchoffs->idusers);
    }

    protected function create_show(Request $request){

     	$branchoffs = BranchOffice::create([
	        'name' => $request['name'],
	        'email' => $request['email'],
	        'phone' => $request['phone'],
	        'address' => $request['address'],
	        'location' => $request['location'],
	        'province' => $request['province'],
	        'pat' => '',
	        'continuity' => '',
	        'differentials' => '',
	        'thermography' => '',
	        'idusers' => $request['idusers'],
	    ]);

        Flash::success("Se ha registrado la sucursal ".$branchoffs->name);
        return Redirect::back();
    }

    protected function update(Request $request){

    	$branchoffs = BranchOffice::find($request['idusers']);
		$branchoffs->name = $request['name'];
		$branchoffs->email = $request['email'];
		$branchoffs->phone = $request['phone'];
		$branchoffs->address = $request['address'];
		$branchoffs->location = $request['location'];
		$branchoffs->province = $request['province'];
		$branchoffs->pat = $request['pat'];
		$branchoffs->continuity = $request['continuity'];
		$branchoffs->differentials = $request['differentials'];
		$branchoffs->thermography = $request['thermography'];
		$branchoffs->save();

		Flash::success("Se ha modificado la sucursal ".$branchoffs->name);
       return redirect()->route('usuarios.editar', $branchoffs->idusers);
    }

    protected function destroy($id){

       $branchoffs = BranchOffice::find($id);
       $meas = $branchoffs->MeasurementUnion()->get();
       foreach ($meas as $m) {
	    	$values = $m->ValueUnion()->get();
	    	foreach ($values as $v) {
	    		$v = Value::find($v->id)->delete();
	    	}
			$m->delete();
       }
       $branchoffs->delete($id);

       Flash::error("Se ha eliminado la sucursal ".$branchoffs->name);
       return redirect()->back();
    }
}
