
@extends('master-formularios', ['titulo' => 'Asistencia', 'seccion' => 'asistencias'])

@section('content') 
    <div class="content">
        <div id="main">
            @if ($status == 'success')
            <div class="row">
                <div class="row">
                    <div id="alerta" class="col-xs-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Datos actualizados satisfactoriamente.
                        </div>
                    </div>
                </div>
            </div>
	        @endif
            <div class="row">
                <form action="{{ url('consultar_clases') }}" method="post">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Clase</h4>
                            </div>
                            <div class="col-md-12">
                                <p>Seleccione la fecha de la sesión de clase.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Fecha</label>
                                <input type="text" data-role="datepicker" name="fecha" id="fecha" class="form-control" autocomplete="off" value="{{ old('fecha') ? old('fecha') : '' }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-primary" value="Consultar" id="consultar_documento" style="margin-top:25px;">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="row">
            @if($clases)
                <form action="{{ url('guardar_asistencia') }}" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Avance</th>
                                        <th>Asistio</th>
                                    </tr>
                                </thead>
                                @foreach($clases as $k => $clases_hora)
                                    <tr style="background-color: #ccc;">
                                        <td colspan="3"><strong>{{ ($k < 10 ? '0'.$k : $k).':00' }}</strong></td>
                                    </tr>
                                    @foreach($clases_hora as $clase)
                                        <tr>
                                            <td>
                                                <p style="line-height:30px;">{{ $clase->beneficiario['Nombre'] }}</p>
                                                <input type="hidden" name="id[]" value="{{ $clase['Id_Asistencia'] }}">
                                            </td>
                                            <?php
                                                if ($clase->Nivel_Destreza)
                                                {
                                                    $nivel = $clase->Nivel_Destreza;
                                                } else if ($clase->beneficiario->asistencias_revisadas->count() > 0) {
                                                    $ultima_clase = $clase->beneficiario->asistencias_revisadas->last();
                                                    $nivel = $ultima_clase->Nivel_Destreza;
                                                } else {
                                                    $nivel = 0;
                                                }
                                            ?>
                                            <td>
                                                <select class="form-control" data-value="{{ $nivel }}" name="{{ $clase->Id_Asistencia }}_nivel" id="">
                                                    @for($i = 0; $i < count($niveles); $i++)
                                                        <option value="{{ $i }}">{{ $niveles[$i] }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input name="{{ $clase->Id_Asistencia }}_asistencia" type="radio" value="Si" {{ $clase->Asistio == 'Si' ? 'checked' : '' }}> Si
                                                </label>
                                                <label class="radio-inline">
                                                    <input name="{{ $clase->Id_Asistencia }}_asistencia" type="radio" value="No" {{ $clase->Asistio == 'No' ? 'checked' : '' }}> No
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                        <div class="col-md-12">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" value="Guardar" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            @endif
            </div>
        </div>
    </div>
@stop