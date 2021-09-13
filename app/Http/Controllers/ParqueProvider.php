<?php

namespace App\Http\Controllers;

use App\Modulos\Parque\Parque;

class ParqueProvider {
	public static function parquesHabilitados() {
		return Parque::whereIn('Id', [8585, 9478, 9989, 9936, 15565, 10721, 10765, 15431])->get();
	}
}