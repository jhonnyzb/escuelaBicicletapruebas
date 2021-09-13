<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
	protected $table = 'Beneficiarios';
    protected $primaryKey = 'Id_Beneficiario';
    protected $connection = 'mysql';
    public $timestamps  = false;

    public function __construct()
    {
    	$this->table = config('database.connections.mysql.database').'.Beneficiarios';
    }

    public function asistencias()
    {
        return $this->hasMany('App\Modulos\Escuela\Asistencia', 'Id_Beneficiario');
    }

    public function asistencias_revisadas()
    {
        return $this->asistencias()->whereNotNull('Nivel_Destreza');
    }
}