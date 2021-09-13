<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsuarioController extends Controller
{
    private $promotor;

    public function __construct()
	{
		if (isset($_SESSION['Usuario']))
			$this->usuario = $_SESSION['Usuario'];

		$this->promotor = Promotor::with('persona')
									->where('Id_Persona', $this->usuario[0])
									->first();
	}
}
