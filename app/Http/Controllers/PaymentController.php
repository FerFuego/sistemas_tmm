<?php

namespace App\Http\Controllers;

use App\User;
use App\Alarm;
use App\Payment;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $pay = Payment::all();
        $user = User::all();
        return view('pagos.pagos')->with('pagos', $pay)
                                  ->with('usuarios', $user);
    }

    public function sendMail($id){

        $user = User::findorFail($id);
            
        Mail::send('emails.pago', ['user' => 'Sistema' ], function ($m) use ($user) {
            $m->from('info@sistematmm.com', 'sistematmm');
            $m->to($user->email, $user->name)->subject('Vencimiento de pago');
        });

        Flash::success("Se ha enviado el aviso de pago");
        return Redirect::back(); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $pay = new Payment();
        $pay->date_pay = $request['date_pay'];
        $pay->date_next_pay = $request['date_next_pay'];
        $pay->state = $request['state'];
        $pay->iduser = $request['iduser'];
        $pay->save();

        Flash::success("Se ha registrado el pago");
        return Redirect::back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function destroy($id){
        $obj = Payment::find($id)->delete();
        return Redirect::back();
    }
}
