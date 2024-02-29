<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Validity extends Model
{
	use Notifiable;
   	use SoftDeletes;	

   	protected $table = 'validities';

    protected $fillable = ['type','since','until','state'];

    /**
     *Los atributos que deben mutarse a las fechas.
     *
     * @var array
     */
    protected $fechas = [ 'deleted_at']; 
}
