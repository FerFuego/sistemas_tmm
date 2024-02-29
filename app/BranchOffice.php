<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchOffice extends Model
{
   use Notifiable;
   use SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'location', 'province','address', 'pat', 'continuity', 'differentials','thermography', 'idusers'
    ];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 
    

    public function UserUnion(){
        return $this->belongsTo('App\User','id');
    }

    public function MeasurementUnion(){
        return $this->hasMany('App\Measurement','idbranch_office');
    }

     public function ValueUnion(){
        return $this->hasMany('App\Value','idbranch_office');
    }
    
}
