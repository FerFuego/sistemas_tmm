<?php

namespace App\Http\Controllers;

use App\Report;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller{

    protected function store(Request $request){
    	$r = new Report();
    	$r->date = $request['date'];
    	$r->title = $request['title'];
    	$r->detail = $request['detail'];
    	$r->importance = $request['importance'];
    	$r->idvalues = $request['idvalues'];
    	$r->save();

    	Flash::success("Se ha registrado el reporte");
        return Redirect::back();
    }

    protected function update(Request $request){
        $r = Report::findOrFail($request['id']);
        $r->date = $request['date'];
        $r->title = $request['title'];
        $r->detail = $request['detail'];
        $r->importance = $request['importance'];
        $r->idvalues = $request['idvalues'];
        $r->save();

        Flash::success("Se ha registrado el reporte");
        return Redirect::back();
    }

    protected function destroy($id){
		$r = Report::find($id)->delete();
		return Redirect::back();
	}
}
