<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
	protected $table = 'Asistencia';
    protected $primaryKey = 'Id_Asistencia';
    protected $connection = 'mysql';
    public $timestamps  = false;

    public function __construct()
    {
    	$this->table = config('database.connections.mysql.database').'.Asistencia';
    }
    
    public function beneficiario()
    {
        return $this->belongsTo('App\Modulos\Escuela\Beneficiario', 'Id_Beneficiario');
    }

    public function promotor()
    {
        return $this->belongsTo('App\Modulos\Escuela\Promotor', 'Id_Promotor');
    }
    
    public function escenario()
    {
        return $this->belongsTo('App\Modulos\Escuela\Escenario', 'Id_Escenario');
    }
}