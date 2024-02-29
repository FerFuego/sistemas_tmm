<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use Notifiable;
   	use SoftDeletes; 

   	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
    	'date','attr_1','attr_2','attr_3','imagen','idusers'
    ];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 

    public function userUnion(){
        return $this->belongsTo('App\User','id');
    }
}
