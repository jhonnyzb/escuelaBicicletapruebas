<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Promotor extends Model
{
	protected $table = 'Promotores';
    protected $primaryKey = 'Id_Promotor';
    protected $connection = 'mysql';
    protected $cascadeDeletes = ['jornadas'];
    protected $dates = ['deleted_at'];

    public function __construct()
    {
    	$this->table = config('database.connections.mysql.database').'.Promotores';
    }

    public function persona()
    {
    	return $this->belongsTo('App\Modulos\Persona\Persona', 'Id_Persona');
    }

    public function jornadas()
    {
        return $this->hasMany('App\Modulos\Escuela\Jornada', 'Id_Promotor');
    }

    public function getCode()
    {
        return 'U'.str_pad($this->Id_Promotor, 5, '0', STR_PAD_LEFT);
    }

    public function escenarios()
    {
        return $this->belongsToMany('App\Modulos\Escuela\Escenario', 'Promotor_Escenario', 'Id_promotor','Id_escenario');
    }

    public function asistencias()
    {
        return $this->hasMany('App\Modulos\Escuela\Asistencia', 'Id_Promotor');
    }

    use SoftDeletes, CascadeSoftDeletes;
}