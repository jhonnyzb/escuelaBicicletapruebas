<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class ActividadRegistros extends Model
{
	protected $table = 'Actividad_Registros';
    protected $primaryKey = 'Id_Registro';
    protected $connection = 'mysql';
    protected $dates = ['deleted_at'];

    public function __construct()
    {
    	$this->table = config('database.connections.mysql.database').'.Actividad_Registros';
    }

    public function actividad()
    {
        return $this->belongsTo('App\Modulos\Escuela\Actividad', 'Id_Actividad');
    }

    public function getCode()
    {
        return 'R'.str_pad($this->Id_Evidencia, 5, '0', STR_PAD_LEFT);
    }

    use SoftDeletes, CascadeSoftDeletes;
}