<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Actividad extends Model
{
	protected $table = 'Actividades_Institucionales';
    protected $primaryKey = 'Id_Actividad';
    protected $connection = 'mysql';
    protected $dates = ['deleted_at'];

    public function __construct()
    {
    	$this->table = config('database.connections.mysql.database').'.Actividades_Institucionales';
    }

    public function promotor()
    {
    	return $this->belongsTo('App\Modulos\Escuela\Promotor', 'Id_Promotor');
    }

    public function evidencias()
    {
        return $this->hasMany('App\Modulos\Escuela\ActividadEvidencias', 'Id_Actividad');
	}
	
	public function registros()
    {
        return $this->hasMany('App\Modulos\Escuela\ActividadRegistros', 'Id_Actividad');
    }

    public function getCode()
    {
        return 'A'.str_pad($this->Id_Actividad, 5, '0', STR_PAD_LEFT);
    }

    use SoftDeletes, CascadeSoftDeletes;
}