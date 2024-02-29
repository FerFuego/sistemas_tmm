<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RangeValue extends Model
{
   use Notifiable;
   use SoftDeletes; 

    protected $table = 'ranges_values';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [ 
    	'since','until','observation','recomendation','idranges',
    ];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 
    

    public function RangeUnion(){
        return $this->belongsTo('App\Range','id');
    }
}
