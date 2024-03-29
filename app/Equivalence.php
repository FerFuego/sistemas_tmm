<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equivalence extends Model
{
    use Notifiable;
   	use SoftDeletes;

   	protected $fillable = [ 
    	'code','value','type','observation','recommendation'
    ];

    protected $fechas = [ 'deleted_at']; 
}
