<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alarm extends Model
{
   use Notifiable;
   use SoftDeletes; 
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
    	'date','type','title','detail','state','idvalues','name','email','published'
    ];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 

    public function ValueUnion(){
        return $this->belongsTo('App\Value','id');
    }
}
