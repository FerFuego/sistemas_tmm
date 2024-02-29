<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criticality extends Model
{
   use Notifiable;
   use SoftDeletes; 

   protected $table = 'criticalities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
    	'since_1', 'since_2', 'since_3', 'since_4', 'until_1', 'until_2', 'until_3', 'until_4', 'observation_1', 'observation_2', 'observation_3', 'observation_4', 'type'
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
