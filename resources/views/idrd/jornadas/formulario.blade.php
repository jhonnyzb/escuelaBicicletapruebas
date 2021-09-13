@section('script')
    @parent

    <script src="{{ asset('public/components/bootstrap-validator/dist/validator.min.js') }}"></script>
    <script src="{{ asset('public/Js/jornadas/formulario.js?v=8') }}"></script>
    <script src="{{ asset('public/Js/jornadas/validaciones.js?v=8') }}"></script>
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
                <form id="principal" action="{{ url('jornadas/procesar') }}" method="post">
                    <fieldset>
                        <div class="col-md-12">
                            <h4>Datos generales de la jornada</h4>
                        </div>
						<div class="col-md-3 form-group {{ $errors->has('Id_Parque') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Lugar</label>
							<select class="form-control" name="Id_Parque" id="" title="Seleccionar" data-value="{{ $jornada ? $jornada['Id_Parque'] : old('Id_Parque') }}">
								@foreach($parques as $parque)
									<option data-localidad="{{ $parque['Id_Localidad'] }}" value="{{ $parque['Id_Escenario'] }}">{{ $parque['Nombre'] }}</option>
								@endforeach
							</select>
						</div>
                        <div class="col-md-3 form-group  {{ $errors->has('Id_Localidad') ? 'has-error' : '' }}">
                            <label for="">* Localidad</label>
                            <select class="form-control" name="Id_Localidad" id="" title="Seleccionar" data-value="{{ $jornada ? $jornada['Id_Localidad'] : old('Id_Localidad') }}">
                                <option value="{{ 0 }}">No aplica</option>
                                @foreach($localidades as $localidad)
                                    <option value="{{ $localidad['Id_Localidad'] }}">{{ $localidad['Localidad'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('Clima') ? 'has-error' : '' }}">
                            <label for="" class="control-label">* Clima</label>
                            <select class="form-control" name="Clima" id="" title="Seleccionar" data-value="{{ $jornada ? $jornada['Clima'] : old('Clima') }}">
                                <option value="Lluvioso">Lluvioso</option>
                                <option value="Soleado">Soleado</option>
                                <option value="Nublado">Nublado</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('Fecha') ? 'has-error' : '' }}">
                            <label for="" class="control-label">* Fecha</label>
                            <input class="form-control" type="text" name="Fecha" data-role="datepicker" value="{{ $jornada ? $jornada['Fecha'] : old('Fecha') }}">
                        </div>
                        <div class="col-md-12">
                            <br>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('Tipo') ? 'has-error' : '' }}">
                            <label for="" class="control-label">* Tipo</label>
                            <select class="form-control" name="Tipo" id="" title="Seleccionar" data-value="{{ $jornada ? $jornada['Tipo'] : old('Tipo') }}">
                                <option value="Proceso de aprendizaje">Proceso de aprendizaje</option>
                                <option value="Taller de mecánica">Taller de mecánica</option>
                                <option value="Ciclo expedición">Ciclo expedición</option>
                            </select>
                        </div>
						<div class="col-md-9 form-group {{ $errors->has('Nombre_Encargado') ? 'has-error' : '' }}">
							<label for="" class="control-label">* Encargado(s) <small>separados por ","</small></label>
							<input class="form-control" type="text" name="Nombre_Encargado" value="{{ $jornada ? $jornada['Nombre_Encargado'] : old('Nombre_Encargado', $promotor ? $promotor->persona->toFriendlyString() : '') }}">
						</div>
                        <div class="col-md-12 form-group">
                            <label for="" class="control-label">Observaciones</label>
                            <textarea name="Observaciones_Generales" id="Observaciones_Generales" cols="30" rows="10" class="form-control">{{ $jornada ? $jornada['Observaciones_Generales'] : old('Observaciones_Generales') }}</textarea>
                        </div>
                        <div class="col-xs-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <h4>Participantes
                                <div class="btn-group" role="group" aria-label="...">
                                    <a id="agregar" href="#" class="btn btn-sm btn-default">agregar</a>
                                </div>
                            </h4>
                        </div>
                        <div class="col-xs-12">
                        	<br>
                        </div>
                        <div class="col-md-12 col-xs-12">
                        	<table id="table_objects" class="table table-min default">
                                <thead>
                        			<tr>
                                        <th class="all">Usuario</th>
                                        <th class="all">Tipo <br> de doc.</th>
                                        <th class="all">Nº de documento <br> usuario</th>
                                        <th class="all">Genero</th>
                                        <th class="all">Edad</th>
                                        <th class="all">CB</th>
                                        <th class="none">Hora inicio</th>
                                        <th class="none">Hora fin</th>
                                        <th class="none">Nº de documento <br> acudiente</th>
                                        <th class="none">Acudiente</th>
                                        <th class="none">Correo</th>
                                        <th class="none">Télefono</th>
                                        <th class="all">Destreza <br> inicial</th>
                                        <th class="all">Avance <br> logrado</th>
                        				<th class="none">Observaciones</th>
                        				<th width="30px" data-priority="2" style="width: 30px;" class="no-sort"></th>
                        			</tr>
                                </thead>
                        	</table>
                        </div>
                        <div class="col-xs-12">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="usuarios" value="{{ $jornada ? json_encode($jornada->usuarios) : old('usuarios') }}">
                            <input type="hidden" name="Id_Jornada" value="{{ $jornada ? $jornada['Id_Jornada'] : 0 }}">
                            <input type="hidden" name="Id_Promotor" value="{{ $jornada ? $jornada['Id_Promotor'] : $promotor['Id_Promotor'] }}">
                            <button id="guardar" type="submit" class="btn btn-primary">Guardar</button>
                            @if ($jornada)
                                <a data-toggle="modal" data-target="#modal-eliminar" class="btn btn-danger">Eliminar</a>
								<a href="{{ url('jornadas/'.$jornada['Id_Jornada'].'/exportar') }}" class="btn btn-success">Exportar</a>
							@endif
                            <a href="{{ url('jornadas') }}" class="btn btn-default">Volver</a>
                        </div>
                        <div class="col-xs-12"><br></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-agregar" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="participante" data-toggle="validator" role="form">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Participante</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      <h5>Usuario</h5>
                  </div>
                  <div class="col-md-12">
                      <div class="row">
                          <div class="col-md-3 form-group">
                              <div class="form-group">
                                  <label class="control-label" for="Nombre_Tipo_Documento_Usuario">* Tipo documento</label>
                                  <select class="form-control" name="Nombre_Tipo_Documento_Usuario" id="Nombre_Tipo_Documento_Usuario" title="Seleccionar" required>
                                      @foreach ($documentos as $documento)
                                          <option value="{{ $documento['Nombre_TipoDocumento'] }}">{{ $documento['Descripcion_TipoDocumento'] }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-3 form-group">
                              <label class="control-label" for="Documento_Usuario">* Documento</label>
                              <input class="form-control" data-url="{{ url('jornadas/consultarUsuario') }}" name="Documento_Usuario" type="number" value="" required>
                          </div>
                          <div class="col-md-6 form-group">
                              <label class="control-label">* Nombre</label>
                              <input class="form-control" name="Nombre_Usuario" type="text" value="" required>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3 form-group">
                      <label class="control-label">* Edad</label>
                      <input class="form-control" name="Edad_Usuario" type="number" min=0 value="" required>
                  </div>
                  <div class="col-md-3 form-group">
                      <label class="control-label" for="CB_Usuario">* Ciclo biológico</label>
                      <select class="form-control" name="CB_Usuario" id="CB_Usuario" title="Seleccionar" required>
                          <option value="P.I">Primera infancia</option>
                          <option value="I">Infancia</option>
                          <option value="ADO">Adolescencia</option>
                          <option value="ADU">Adultez</option>
                          <option value="VE">Vejez</option>
                      </select>
                  </div>
                  <div class="col-md-3 form-group">
                      <label class="control-label" for="genero1">* Género</label> <br>
                      <label class="radio-inline">
                          <input type="radio" name="Genero_Usuario" id="genero1" value="M" required> Masculino
                      </label>
                      <label class="radio-inline">
                          <input type="radio" name="Genero_Usuario" id="genero2" value="F" required> Femenino
                      </label>
                  </div>
                  <div class="col-md-3" style="padding-top: 22px;">
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="Acudiente_Es_Usuario" value="1">
                              El usuario es el acudiente
                          </label>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <hr>
                  </div>
                  <div class="col-md-12">
                      <h5>Acudiente</h5>
                  </div>
                  <div class="col-md-3 form-group">
                      <div class="form-group">
                        <label class="control-label" for="Documento_Acudiente">* Documento</label>
                        <input class="form-control" name="Documento_Acudiente" type="number" value="" required>
                      </div>
                  </div>
                  <div class="col-md-9 form-group">
                      <div class="form-group">
                          <label class="control-label" for="Nombre_Acudiente">* Nombre</label>
                          <input class="form-control" name="Nombre_Acudiente" type="text" value="" required>
                      </div>
                  </div>
                  <div class="col-md-6 form-group">
                      <div class="form-group">
                          <label class="control-label" for="Email_Acudiente">Email</label>
                          <input class="form-control" name="Email_Acudiente" type="text" value="">
                      </div>
                  </div>
                  <div class="col-md-6 form-group">
                      <div class="form-group">
                          <label class="control-label" for="Telefono_Acudiente">* Teléfono</label>
                          <input class="form-control" name="Telefono_Acudiente" type="number" value="">
                      </div>
                  </div>
                  <div class="col-md-12">
                      <hr>
                  </div>
                  <div class="col-md-12">
                      <h5>Jornada</h5>
                  </div>
                  <div class="col-md-3 form-group">
                      <label class="control-label" for="Hora_Inicio_Usuario">* Hora de inicio</label>
                      <input class="form-control" name="Hora_Inicio_Usuario" data-role="clockpicker" data-rel="hora_inicio" type="text" required>
                  </div>
                  <div class="col-md-3 form-group">
                      <label class="control-label" for="Hora_Fin_Usuario">* Hora de finalización</label>
                      <input class="form-control" name="Hora_Fin_Usuario" data-role="clockpicker" data-rel="hora_fin" type="text" required>
                  </div>
                  <div class="col-md-3 form-group">
                      <label class="control-label" for="Destreza_Inicial_Usuario">* Destreza inicial</label>
                      <select class="form-control" name="Destreza_Inicial_Usuario" title="Seleccionar" required>
                          <option value="A">A - No sabe montar bicicleta</option>
                          <option value="B">B - Pedalea con ruedas de entrenamiento</option>
                          <option value="C">C - Camina con la bicicleta</option>
                          <option value="D">D - Se impulsa y mantiene equilibrio por instantes</option>
                          <option value="E">E - Se impulsa y mantiene equilibrio</option>
                          <option value="F">F - Pedalea con apoyo</option>
                          <option value="G">G - Pedalea y mantiene equilibrio por instantes</option>
                          <option value="H">H - Maneja</option>
                          <option value="I">I - Maneja y adquiere otras habilidades sobre la bicicleta</option>
                      </select>
                  </div>
                  <div class="col-md-3 form-group">
                      <label class="control-label" for="Avance_Logrado_Usuario">* Avance logrado</label>
                      <select class="form-control" name="Avance_Logrado_Usuario" title="Seleccionar" required>
                          <option value="A">A - No sabe montar bicicleta</option>
                          <option value="B">B - Pedalea con ruedas de entrenamiento</option>
                          <option value="C">C - Camina con la bicicleta</option>
                          <option value="D">D - Se impulsa y mantiene equilibrio por instantes</option>
                          <option value="E">E - Se impulsa y mantiene equilibrio</option>
                          <option value="F">F - Pedalea con apoyo</option>
                          <option value="G">G - Pedalea y mantiene equilibrio por instantes</option>
                          <option value="H">H - Maneja</option>
                          <option value="I">I - Maneja y adquiere otras habilidades sobre la bicicleta</option>
                      </select>
                  </div>
                  <div class="col-md-12 form-group">
                      <label class="control-label" for="Observaciones_Usuario">Observaciones</label>
                      <textarea name="Observaciones_Usuario" class="form-control"></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <input type="hidden" name="Id_Usuario" value="">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
      </form>
    </div>
  </div>
</div>
@if ($jornada)
    <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>Realmente desea eliminar esta jornada.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('jornadas/'.$jornada['Id_Jornada'].'/eliminar') }}" class="btn btn-danger">Eliminar</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endif
