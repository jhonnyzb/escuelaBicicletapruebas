@section('script')
    @parent
	<script>
		$(function() {
			$('input[name="Participantes_Femenino"],input[name="Participantes_Masculino"]').on('keyup', function(e) {
				var femenino = parseInt($('input[name="Participantes_Femenino"]').val(), 10) * 1;
				var masculino = parseInt($('input[name="Participantes_Masculino"]').val(), 10) * 1;

				console.log('total', femenino, masculino);

				$('#total_participantes').text(isNaN(femenino) ? 0 + femenino + isNaN(masculino) : 0 + masculino);
			})
		})
	</script>
@stop

<div class="content">
    <div id="main" class="row">
        @if ($status == 'success')
            <div id="alerta" class="col-xs-12">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Datos actualizados satisfactoriamente.
                </div>
            </div>
        @endif
        @if (!empty($errors->all()))
            <div class="col-xs-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Solucione los siguientes inconvenientes y vuelva a intentarlo</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="col-xs-12"><br></div>
        <div class="col-xs-12">
            <div class="row">
                <form id="principal" action="{{ url('actividades/procesar') }}" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="col-md-12">
                            <h4>Actividad institucional<br /><br /></h4>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('Fecha') ? 'has-error' : '' }}">
                            <label for="" class="control-label">* Fecha</label>
                            <input class="form-control" type="text" name="Fecha" data-role="datepicker" value="{{ $actividad ? $actividad['Fecha'] : old('Fecha') }}">
                        </div>
                        <div class="col-md-9 form-group {{ $errors->has('Nombre_Del_Evento') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Nombre del evento</label>
							<input class="form-control" type="text" name="Nombre_Del_Evento" value="{{ $actividad ? $actividad['Nombre_Del_Evento'] : old('Nombre_Del_Evento') }}">
						</div>
                        <div class="col-md-12 form-group {{ $errors->has('Tipo') ? 'has-error' : '' }}">
                            <label class="control-label" for="tipo0">* Tipo de actividad</label> <br>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo" id="tipo0" value="Ciclopaseo" {{ $actividad['Tipo'] == 'Ciclopaseo' || old('Tipo') == 'Ciclopaseo' ? 'checked' : '' }}> Ciclopaseo
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo" id="tipo1" value="Presencia institucional" {{ $actividad['Tipo'] == 'Presencia institucional' || old('Tipo') == 'Presencia institucional' ? 'checked' : '' }}> Presencia institucional
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo" id="tipo2" value="Instituciones" {{ $actividad['Tipo'] == 'Instituciones' || old('Tipo') == 'Instituciones' ? 'checked' : '' }}> Instituciones
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo" id="tipo3" value="Taller de mecánica" {{ $actividad['Tipo'] == 'Taller de mecánica' || old('Tipo') == 'Taller de mecánica' ? 'checked' : '' }}> Taller de mecánica
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo" id="tipo4" value="Extemporáneo" {{ $actividad['Tipo'] == 'Extemporáneo' || old('Tipo') == 'Extemporáneo' ? 'checked' : '' }}> Extemporáneo
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo" id="tipo5" value="Evento metropolitano" {{ $actividad['Tipo'] == 'Evento metropolitano' || old('Tipo') == 'Evento metropolitano' ? 'checked' : '' }}> Evento metropolitano
                            </label>
                        </div>
                        <div class="col-md-12 form-group {{ $errors->has('Mecanicos') ? 'has-error' : '' }}">
                            <label class="control-label" for="Mecanicos">* Guías y/o mecánicos encargados</label> <small>Separar con punto y coma</small>
                            <textarea name="Mecanicos" class="form-control">{{ $actividad ? $actividad['Mecanicos'] : old('Mecanicos') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <h5>Datos generales de la actividad</h5>
                        </div>
                        <div class="col-md-12 form-group {{ $errors->has('Objetivo') ? 'has-error' : '' }}">
                            <label class="control-label" for="Objetivo">* Objetivo de la actividad</label>
                            <textarea name="Objetivo" class="form-control">{{ $actividad ? $actividad['Objetivo'] : old('Objetivo') }}</textarea>
                        </div>
                        <div class="col-md-4 form-group {{ $errors->has('Empresa') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Nombre de la empresa o entidad</label>
							<input class="form-control" type="text" name="Empresa" value="{{ $actividad ? $actividad['Empresa'] : old('Empresa') }}">
						</div>
                        <div class="col-md-4 form-group {{ $errors->has('Encargado') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Persona encargada</label>
							<input class="form-control" type="text" name="Encargado" value="{{ $actividad ? $actividad['Encargado'] : old('Encargado') }}">
						</div>
                        <div class="col-md-4 form-group {{ $errors->has('Telefono') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Teléfono</label>
							<input class="form-control" type="text" name="Telefono" value="{{ $actividad ? $actividad['Telefono'] : old('Telefono') }}">
						</div>
                        <div class="col-md-4 form-group {{ $errors->has('Punto_De_Encuentro') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Punto de encuentro</label>
							<input class="form-control" type="text" name="Punto_De_Encuentro" value="{{ $actividad ? $actividad['Punto_De_Encuentro'] : old('Punto_De_Encuentro') }}">
						</div>
                        <div class="col-md-4 form-group {{ $errors->has('Hora_Inicio') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Hora inicio</label>
							<input class="form-control" type="time" name="Hora_Inicio" value="{{ $actividad ? $actividad['Hora_Inicio'] : old('Hora_Inicio') }}">
						</div>
                        <div class="col-md-4 form-group {{ $errors->has('Hora_Fin') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Hora fin</label>
							<input class="form-control" type="time" name="Hora_Fin" value="{{ $actividad ? $actividad['Hora_Fin'] : old('Hora_Fin') }}">
						</div>
                        <div class="col-md-4 form-group {{ $errors->has('Participantes_Femenino') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Participantes (Mujeres)</label>
							<input class="form-control" type="number" name="Participantes_Femenino" value="{{ $actividad ? $actividad['Participantes_Femenino'] : old('Participantes_Femenino') }}">
						</div>
                        <div class="col-md-4 form-group {{ $errors->has('Participantes_Masculino') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Participantes (Hombres)</label>
							<input class="form-control" type="number" name="Participantes_Masculino" value="{{ $actividad ? $actividad['Participantes_Masculino'] : old('Participantes_Masculino') }}">
						</div>

                        <div class="col-md-4 form-group">
							<label for="" class="control-label">* Participantes</label>
							<p id="total_participantes" class="form-control-static">{{ $actividad ? $actividad['Participantes_Femenino'] + $actividad['Participantes_Masculino'] : 0 }}</p>
						</div>
                        <div class="col-md-12">
                            <h5>Apoyos a la actividad</h5>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('Apoyo_Mecanicos') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Guías o mecánicos escuela de la bicicleta</label>
							<input class="form-control" type="number" name="Apoyo_Mecanicos" value="{{ $actividad ? $actividad['Apoyo_Mecanicos'] : old('Apoyo_Mecanicos', 0) }}">
						</div>
                        <div class="col-md-3 form-group {{ $errors->has('Apoyo_Guardianes') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Guardianes de ciclovía</label>
							<input class="form-control" type="number" name="Apoyo_Guardianes" value="{{ $actividad ? $actividad['Apoyo_Guardianes'] : old('Apoyo_Guardianes', 0) }}">
						</div>
                        <div class="col-md-3 form-group {{ $errors->has('Apoyo_Movilidad') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Guías de movilidad</label>
							<input class="form-control" type="number" name="Apoyo_Movilidad" value="{{ $actividad ? $actividad['Apoyo_Movilidad'] : old('Apoyo_Movilidad', 0) }}">
						</div>
                        <div class="col-md-3 form-group {{ $errors->has('Apoyo_Policias') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Policias</label>
							<input class="form-control" type="number" name="Apoyo_Policias" value="{{ $actividad ? $actividad['Apoyo_Policias'] : old('Apoyo_Policias', 0) }}">
						</div>
                        <div class="col-md-3 form-group {{ $errors->has('Apoyo_Otros') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Otros apoyos</label>
							<input class="form-control" type="number" name="Apoyo_Otros" value="{{ $actividad ? $actividad['Apoyo_Otros'] : old('Apoyo_Otros', 0) }}">
						</div>
                        <div class="col-md-12">
                            <h5>Prestamo de bicicletas</h5>
                            <small>Debe escribir la cantidad de bicicletas por cada tipo. En caso de no realizar algún préstamo, diligenciar con cero (0)</small>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('Prestamos_Rin12') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Bicicletas RIN 12</label>
							<input class="form-control" type="number" name="Prestamos_Rin12" value="{{ $actividad ? $actividad['Prestamos_Rin12'] : old('Prestamos_Rin12', 0) }}">
						</div>
                        <div class="col-md-3 form-group {{ $errors->has('Prestamos_Rin16') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Bicicletas RIN 16</label>
							<input class="form-control" type="number" name="Prestamos_Rin16" value="{{ $actividad ? $actividad['Prestamos_Rin16'] : old('Prestamos_Rin16', 0) }}">
						</div>
                        <div class="col-md-3 form-group {{ $errors->has('Prestamos_Rin20') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Bicicletas RIN 20</label>
							<input class="form-control" type="number" name="Prestamos_Rin20" value="{{ $actividad ? $actividad['Prestamos_Rin20'] : old('Prestamos_Rin20', 0) }}">
						</div>
                        <div class="col-md-3 form-group {{ $errors->has('Prestamos_Rin26') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Bicicletas RIN 26</label>
							<input class="form-control" type="number" name="Prestamos_Rin26" value="{{ $actividad ? $actividad['Prestamos_Rin26'] : old('Prestamos_Rin26', 0) }}">
						</div>
                        <div class="col-md-12">
                            <h5>Datos específicos para ciclopaseos</h5>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="control-label" for="Recorrido">Descripción del recorrido</label>
                            <textarea name="Recorrido" class="form-control">{{ $actividad ? $actividad['Recorrido'] : old('Recorrido') }}</textarea>
                        </div>
                        <div class="col-md-6 form-group">
							<label for="" class="control-label">Dirección de finalización</label>
							<input class="form-control" type="text" name="Direccion_Finalizacion" value="{{ $actividad ? $actividad['Direccion_Finalizacion'] : old('Direccion_Finalizacion') }}">
						</div>
                        <div class="col-md-3 form-group">
							<label for="" class="control-label">Total de kilómetros recorridos</label>
							<input class="form-control" type="text" name="Kilometros_Recorridos" value="{{ $actividad ? $actividad['Kilometros_Recorridos'] : old('Kilometros_Recorridos') }}">
						</div>
                        <div class="col-md-3 form-group">
                            <label class="control-label" for="tipo_r0">Tipo de recorrido</label> <br>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo_De_Recorrido" id="tipo_r0" value="Solo ida" {{ $actividad['Tipo_De_Recorrido'] == 'Solo ida' || old('Tipo_De_Recorrido') == 'Solo ida' ? 'checked' : '' }}> Solo ida
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="Tipo_De_Recorrido" id="tipo_r1" value="Ida y vuelta" {{ $actividad['Tipo_De_Recorrido'] == 'Ida y vuelta' || old('Tipo_De_Recorrido') == 'Ida y vuelta' ? 'checked' : '' }}> Ida y vuelta
                            </label>
                        </div>
                        <div class="col-md-12">
                            <h5>Observaciones generales</h5>
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea name="Observaciones" class="form-control">{{ $actividad ? $actividad['Observaciones'] : old('Observaciones') }}</textarea>
                        </div>
						<div class="col-md-12">
                            <h5>Registro esquemático del recorrido</h5>
                        </div>
                        <div class="col-md-12">
                            <input type="file" name="Registros[]" multiple>
                        </div>
						@if($actividad)
							<div class="row">
								<div class="col-xs-12">
									<div class="col-xs-12">
										<table class="table">
											<thead>
												<tr>
													<th>Registro</th>
													<th width=30></th>
												</tr>
											</thead>
											<tbody>
												@foreach($actividad->registros as $registro)
													@if ($registro->deleted_at === null)
													<tr>
														<td>
															<a target="_blank" href="{{ public_path('registros').'/'.$registro['Archivo'] }}">
																{{ substr($registro['Archivo'], 6) }}
															</a>
														</td>
														<td>
															@if($_SESSION['Usuario'][0] === $promotor['Id_Persona'])
																<a class="btn btn-xs btn-danger" href="{{ url('registros/'.$registro['Id_Registro'].'/eliminar') }}">
																	<i class="fa fa-trash"></i>
																</a>
															@endif
														</td>
													</tr>
													@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@endif
                        <div class="col-md-12">
                            <h5>Registro fotográfico de la actividad</h5>
                            <small>Incluir mínimo 6 fotografías</small>
                        </div>
                        <div class="col-md-12">
                            <input type="file" name="Evidencias[]" multiple>
                        </div>
						@if($actividad)
							<div class="row">
								<div class="col-xs-12">
									<div class="col-xs-12">
										<table class="table">
											<thead>
												<tr>
													<th>Evidencia</th>
													<th width="30"></th>
												</tr>
											</thead>
											<tbody>
												@foreach($actividad->evidencias as $evidencia)
													@if ($evidencia->deleted_at === null)
													<tr>
														<td>
															<a target="_blank" href="{{ public_path('evidencias').'/'.$evidencia['Archivo'] }}">
																{{ substr($evidencia['Archivo'], 6) }}
															</a>
														</td>
														<td>
															@if($_SESSION['Usuario'][0] === $promotor['Id_Persona'])
																<a class="btn btn-xs btn-danger" href="{{ url('evidencias/'.$evidencia['Id_Evidencia'].'/eliminar') }}">
																	<i class="fa fa-trash"></i>
																</a>
															@endif
														</td>
													</tr>
													@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@endif
                        <div class="col-md-12">
                            <br /><br />
                        </div>
						@if($_SESSION['Usuario'][0] === $promotor['Id_Persona'])
							<div class="col-xs-12">
								<input type="hidden" name="_method" value="POST">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="Id_Actividad" value="{{ $actividad ? $actividad['Id_Actividad'] : 0 }}">
								<input type="hidden" name="Id_Promotor" value="{{ $actividad ? $actividad['Id_Promotor'] : $promotor['Id_Promotor'] }}">
								<button id="guardar" type="submit" class="btn btn-primary">Guardar</button>
								@if ($actividad)
									<a data-toggle="modal" data-target="#modal-eliminar" class="btn btn-danger">Eliminar</a>
								@endif
								<a href="{{ url('actividades') }}" class="btn btn-default">Volver</a>
							</div>
						@endif
                        <div class="col-xs-12">
                            <br />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($actividad)
    <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>Realmente desea eliminar esta actividad.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('actividades/'.$actividad['Id_Actividad'].'/eliminar') }}" class="btn btn-danger">Eliminar</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endif

