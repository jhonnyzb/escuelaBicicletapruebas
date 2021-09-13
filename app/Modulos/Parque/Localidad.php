<?php
/**
 * Created by PhpStorm.
 * User: Jona
 * Date: 16/08/2017
 * Time: 8:10 AM
 */

namespace App\Modulos\Parque;

use Idrd\Parques\Repo\Localidad as ILocalidad;

class Localidad extends ILocalidad
{
    public function jornadas()
    {
        return $this->hasMany('App\Modulos\Escuela\Jornada', 'Id_Localidad');
    }

    public function escenarios()
    {
        return $this->hasMany('App\Modulos\Escuela\Escenario', 'Id_Localidad');
    }
}