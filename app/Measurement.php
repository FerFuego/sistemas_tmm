<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement extends Model
{
    use Notifiable;
    use SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [ 'type', 'details', 'observation', 'recommendation', 'idbranch_office', 'idusers', 'sector'];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 
    

    public function BranchUnion(){
        return $this->belongsTo('App\BranchOffice','idbranch_office');
    }

    public function ValueUnion(){
        return $this->hasMany('App\Value','idmeasurements');
    }

}
