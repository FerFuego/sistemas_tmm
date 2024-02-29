<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Value extends Model
{
	use Notifiable;
	use SoftDeletes; 

    protected $table = 'values';

    protected $fillable = ['date','title','value_num','value','value_max','regulation','place','type','state','instrument','reparation','observation','recommendation','criterion','image_1','image_2','image_3','idmeasurements'];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 

    public function UserUnion(){
        return $this->belongsTo('App\Measurement');
    }

    public function BranchUnion(){
        return $this->belongsTo('App\BranchOffice');
    }

    public function ReportUnion(){
        return $this->hasMany('App\Report', 'idvalues');
    }

    public function AlarmtUnion(){
        return $this->hasMany('App\Alarm', 'idvalues');
    }
}
