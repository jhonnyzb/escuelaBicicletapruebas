<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;

class GuardarBeneficiario extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'Id_Tipo_Documento' => 'required|min:1',
            'Documento' => 'required',
            'Nombre' => 'required',
            'Fecha_Nacimiento' => 'required|date',
            'Id_Genero' => 'required',
            'Genero_Poblacional' => 'required',
            'Correo' => 'required|email',
            'Telefono' => 'required',
            'Id_Localidad' => 'required',
            'Id_Upz' => 'required_unless:Id_Localidad,otro',
            'Municipio' => 'required_if:Id_Localidad,otro',
            'Estrato' => 'required'
        ];

        if ($this->input('Fecha_Nacimiento'))
        {
            $born = Carbon::createFromFormat('Y-m-d', $this->input('Fecha_Nacimiento'));

            if($born->age < 18)
            {
                $rules['Tipo_Documento_Acudiente'] = 'required';
                $rules['Documento_Acudiente'] = 'required';
                $rules['Nombre_Acudiente'] = 'required';
            }
        }

        return $rules;
    }
}
