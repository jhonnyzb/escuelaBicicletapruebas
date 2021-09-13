<?php

namespace App\Modulos\Persona;

use Idrd\Usuarios\Repo\Persona as MPersona;

class Persona extends MPersona
{
    public function promotor()
	{
		return $this->hasOne('App\Modulos\Escuela\Promotor', 'Id_Persona')
					->whereNull('deleted_at');
	}

	public function toFriendlyString()
	{
		return trim(strtoupper($this->Primer_Nombre.' '.$this->Primer_Apellido));
	}

	public function toString()
	{
		return trim(strtoupper($this->Primer_Apellido.' '.$this->Segundo_Apellido.' '.$this->Primer_Nombre.' '.$this->Segundo_Nombre));
	}
}