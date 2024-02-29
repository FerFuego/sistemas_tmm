<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
	use Notifiable;
   	use SoftDeletes;	

    protected $table = 'states';

    protected $fillable = ['state','observation','type'];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 

    public function RangeUnion(){
    	return $this->belongsTo('App\Range','type');
    }

}
