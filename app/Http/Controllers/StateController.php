<?php

namespace App\Http\Controllers;

use App\Range;
use App\State;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StateController extends Controller
{
    protected function update(Request $request, $id){

        $st = State::findOrFail(1);
        $st->state = $request['state'][0];
        $st->observation = $request['observation'][0];
        $st->type = $request['type'];
        $st->idranges = $id;
        $st->save();

        $st = State::findOrFail(2);
        $st->state = $request['state'][1];
        $st->observation = $request['observation'][1];
        $st->type = $request['type'];
        $st->idranges = $id;
        $st->save();

        $st = State::findOrFail(3);
        $st->state = $request['state'][2];
        $st->observation = $request['observation'][2];
        $st->type = $request['type'];
        $st->idranges = $id;
        $st->save();

        Flash::success("Se han registrado los valores máximos");
        return Redirect::back();
    }
}
