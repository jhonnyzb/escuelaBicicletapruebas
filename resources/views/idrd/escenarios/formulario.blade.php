@extends('master-formularios', ['titulo' => 'Escenarios', 'seccion' => 'Escenarios'])

@section('content') 
	<div class="content">
	    <div id="main" class="row" data-url="{{ url('personas') }}" data-url-modulo="{{ url('promotores') }}">
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
	                <form action="{{ url('escenarios/procesar') }}" method="post">
	                    <fieldset>
	                        <div class="col-md-12">
	                            <h4>Crear / Editar un escenario</h4>
	                        </div>
	                        <div class="col-xs-12 col-md-3">
	                            <div class="form-group {{ $errors->has('Nombre') ? 'has-error' : '' }}">
	                                <label class="control-label" for="Nombre">* Nombre </label>
	                                <input type="text" name="Nombre" class="form-control" value="{{ $escenario ? $escenario['Nombre'] : old('Nombre', '') }}">
	                            </div>
	                        </div>
	                        <div class="col-xs-12 col-md-3">
	                            <div class="form-group {{ $errors->has('Id_Localidad') ? 'has-error' : '' }}">
	                                <label class="control-label" for="Id_Localidad">* Localidad </label>
	                                <select name="Id_Localidad" id="Id_Localidad" class="form-control" title="Seleccionar" data-value="{{ $escenario ? $escenario['Id_Localidad'] : old('Id_Localidad', '') }}">
	                                	@foreach($localidades as $localidad)
                                			<option value="{{ $localidad['Id_Localidad'] }}">{{ $localidad['Localidad'] }}</option>
										@endforeach
	                                </select>
	                            </div>
	                        </div>
	                        <div class="col-xs-12 col-md-3">
	                            <div class="form-group {{ $errors->has('Hora_Inicio') ? 'has-error' : '' }}">
	                                <label class="control-label" for="Hora_Inicio">* Hora Inicio </label>
	                                <select name="Hora_Inicio" id="Hora_Inicio" class="form-control" title="Seleccionar" data-value="{{ $escenario ? $escenario['Hora_Inicio'] : old('Hora_Inicio', '') }}">
	                                	@for($i=5; $i<=20; $i++)
											<option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT).':00' }}</option>
										@endfor
	                                </select>
	                            </div>
	                        </div>
	                        <div class="col-xs-12 col-md-3">
	                            <div class="form-group {{ $errors->has('Hora_Fin') ? 'has-error' : '' }}">
	                                <label class="control-label" for="Hora_Fin">* Hora Fin </label>
	                                <select name="Hora_Fin" id="Hora_Fin" class="form-control" title="Seleccionar" data-value="{{ $escenario ? $escenario['Hora_Fin'] : old('Hora_Fin', '') }}">
	                                	@for($i=5; $i<=20; $i++)
											<option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT).':00' }}</option>
										@endfor
	                                </select>
	                            </div>
	                        </div>
							<div class="col-xs-12 col-md-3">
								<div class="form-group {{ $errors->has('Habilitado') ? 'has-error' : '' }}">
	                                <label class="control-label" for="Habilitado">* Habilitado </label>
	                                <select name="Habilitado" id="Habilitado" class="form-control" title="Seleccionar" data-value="{{ $escenario ? $escenario['Habilitado'] : old('Habilitado', '') }}">
	                                	<option value="1">Si</option>
	                                	<option value="0">No</option>
	                                </select>
	                            </div>
							</div>
	                        <div class="col-xs-12">
	                            <input type="hidden" name="_method" value="POST">
	                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                            <input type="hidden" name="Id_Escenario" value="{{ $escenario ? $escenario['Id_Escenario'] : old('Id_Escenario', 0) }}">
	                            <button id="guardar" type="submit" class="btn btn-primary">Guardar</button>
	                            @if ($escenario)
	                            	@if($escenario->jornadas->count() == 0)
	                                	<a data-toggle="modal" data-target="#modal-eliminar" class="btn btn-danger">Eliminar</a>
	                                @else
	                                	<small>No se puede eliminar el escenario ya que tiene registradas ({{ $escenario->jornadas->count() }}) jornadas</small>
	                                @endif
	                            @endif
	                            <a href="{{ url('escenarios') }}" class="btn btn-default">Volver</a>
	                        </div>
	                        <div class="col-xs-12"><br></div>
	                    </fieldset>
	                </form>
	            </div>
	        </div>
			<div class="col-xs-12">
				<hr>
			</div>
			<div class="col-xs-12">
	            <div class="row">
	                <form action="{{ url('escenarios/cancelar') }}" method="post">
	                    <fieldset>
	                        <div class="col-md-12">
	                            <h4>Cancelar clases</h4>
	                        </div>
	                        <div class="col-xs-12 col-md-3">
	                            <div class="form-group {{ $errors->has('Fecha') ? 'has-error' : '' }}">
	                                <label class="control-label" for="Fecha">* Fecha </label>
	                                <input type="text" name="Fecha" data-role="datepicker" class="form-control" value="{{ old('Fecha', '') }}">
	                            </div>
	                        </div>
	                        <div class="col-xs-12">
	                            <input type="hidden" name="_method" value="POST">
	                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                            <input type="hidden" name="Id_Escenario" value="{{ $escenario ? $escenario['Id_Escenario'] : old('Id_Escenario', 0) }}">
	                            <button id="cancelar" type="submit" class="btn btn-danger">Cancelar clases</button>
	                        </div>
	                        <div class="col-xs-12"><br></div>
	                    </fieldset>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>
	@if ($escenario)
	    <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title">Eliminar</h4>
	                </div>
	                <div class="modal-body">
	                    <p>Realmente desea eliminar este escenario.</p>
	                </div>
	                <div class="modal-footer">
	                    <a href="{{ url('escenarios/'.$escenario['Id_Escenario'].'/eliminar') }}" class="btn btn-danger">Eliminar</a>
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	                </div>
	            </div>
	        </div>
	    </div>
	@endif
@stop