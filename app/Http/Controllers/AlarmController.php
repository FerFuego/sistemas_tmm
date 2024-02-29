<?php

namespace App\Http\Controllers;

use App\Alarm;
use App\Mail\AlarmaEmail;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AlarmController extends Controller
{
    protected function store(Request $request){
        /**
         * Esta funcion solo crea el registro en DB
         * El envio de email pasa a ser controlado por command schedule y crontab del servidor
         * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
         * @return void
         */

        $i=0;
        foreach ($request['email'] as $val) {

            $r = new Alarm();
            $r->date = $request['date'].' '.$request['datetime'];
            $r->type = $request['type'];
            $r->title = $request['title'];
            $r->detail = $request['detail'];
            $r->state = 'Alarma';
            $r->name = $request['name'][$i];
            $r->email = $request['email'][$i];
            $r->idvalues = $request['idvalues'];
            $r->save();
            $i++;

            //Si se descomenta funciona
            //$data = ['user' => 'system', 'message' => $request['detail'], 'title' => $request['title']];
            //Mail::to($val)->send(new AlarmaEmail($data));
        }


    	Flash::success("Se ha registrado y ha programado el aviso de alarma");
        return Redirect::back();
    }

    protected function update(Request $request){
        $i=0;
        $band = false;

        /**
         * Esta funcion solo edita el registro en DB
         * El envio de email pasa a ser controlado por command schedule y crontab del servidor
         * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
         * @return void
         */

        foreach ($request['email'] as $val) {
            if($band == false){
                $r = Alarm::findOrFail($request['id']);
                $r->date = $request['date'].' '.$request['datetime'];
                $r->type = $request['type'];
                $r->title = $request['title'];
                $r->detail = $request['detail'];
                $r->state = 'Alarma';
                $r->name = $request['name'][$i];
                $r->email = $request['email'][$i];
                $r->idvalues = $request['idvalues'];
                $r->save();

                $band = true;
            }else{
                
                $r = new Alarm();
                $r->date = $request['date'].' '.$request['datetime'];
                $r->type = $request['type'];
                $r->title = $request['title'];
                $r->detail = $request['detail'];
                $r->state = 'Alarma';
                $r->name = $request['name'][$i];
                $r->email = $request['email'][$i];
                $r->idvalues = $request['idvalues'];
                $r->save();
                $i++;
            }

        }


        Flash::success("Se ha registrado y ha programado el aviso de alarma");
        return Redirect::back();
    }

    protected function destroy($id){
		$r = Alarm::find($id)->delete();
		return Redirect::back();
	}
}
