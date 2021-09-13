<?php

namespace App\Modulos\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Usuario extends Model
{
	protected $table = 'Usuarios';
    protected $primaryKey = 'Id_Usuario';
    protected $connection = 'mysql';
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $fillable = ['Id_Usuario', 'Id_Jornada', 'Documento_Acudiente', 'Nombre_Acudiente', 'Email_Acudiente', 'Telefono_Acudiente', 'Acudiente_Es_Usuario', 'Nombre_Usuario', 'Nombre_Tipo_Documento_Usuario', 'Documento_Usuario', 'Genero_Usuario', 'Edad_Usuario', 'CB_Usuario', 'Hora_Inicio_Usuario', 'Hora_Fin_Usuario', 'Destreza_Inicial_Usuario', 'Avance_Logrado_Usuario', 'Observaciones_Usuario', 'created_at', 'updated_at', 'deleted_at'];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    	$this->table = config('database.connections.mysql.database').'.Usuarios';
    }

    public function jornadas()
    {
    	return $this->belongsTo('App\Modulos\Escuela\Jornada','Id_Jornada');
    }

    use SoftDeletes, CascadeSoftDeletes;
}