<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Range extends Model
{
   use Notifiable;
   use SoftDeletes; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
    	'type', 'value_max', 'observation', 'description', 'recomendation'
    ];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 
    

    public function CriticalUnion(){
        return $this->hasMany('App\Criticality','idranges');
    }

    public function RangeValueUnion(){
        return $this->hasMany('App\RangeValue','idranges');
    }

    public function StatesUnion(){
        return $this->hasMany('App\State','type');
    }
}
