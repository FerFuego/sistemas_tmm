<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use Notifiable;
   	use SoftDeletes;	

    protected $table = 'payments';

    protected $fillable = ['state','date_pay','date_next_pay','iduser'];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 

    public function PaymentsUnion(){
    	return $this->belongsTo('App\User');
    }
}
