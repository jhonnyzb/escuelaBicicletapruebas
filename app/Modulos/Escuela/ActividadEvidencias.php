<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class ActividadEvidencias extends Model
{
	protected $table = 'Actividad_Evidencias';
    protected $primaryKey = 'Id_Evidencia';
    protected $connection = 'mysql';
    protected $dates = ['deleted_at'];

    public function __construct()
    {
    	$this->table = config('database.connections.mysql.database').'.Actividad_Evidencias';
    }

    public function actividad()
    {
        return $this->belongsTo('App\Modulos\Escuela\Actividad', 'Id_Actividad');
    }

    public function getCode()
    {
        return 'E'.str_pad($this->Id_Evidencia, 5, '0', STR_PAD_LEFT);
    }

    use SoftDeletes, CascadeSoftDeletes;
}