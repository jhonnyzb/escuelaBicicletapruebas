<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Escenario extends Model {
    
    public $timestamps = false;

	protected $table = 'Escenarios';
    protected $primaryKey = 'Id_Escenario';
    protected $connection = 'mysql';

    public function __construct() {
    	$this->table = config('database.connections.mysql.database').'.Escenarios';
    }

    public function jornadas() {
    	return $this->hasMany('App\Modulos\Escuela\Jornada', 'Id_Parque');
    }

    public function localidad() {
        return $this->belongsTo('App\Modulos\Parque\Localidad', 'Id_Localidad');
    }
   	
    public function getCode() {
        return 'E'.str_pad($this->Id_Escenario, 5, '0', STR_PAD_LEFT);
    }

    public function promotores() 
    {
        return $this->belongsToMany('App\Modulos\Escuela\Promotor', 'Promotor_Escenario', 'Id_escenario', 'Id_promotor');
    }

    public function asistencias()
    {
        return $this->hasMany('App\Modulos\Escuela\Asistencia', 'Id_Escenario');
    }
}