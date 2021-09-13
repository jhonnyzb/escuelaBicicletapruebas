@section('script')
    @parent

    <script src="{{ asset('public/Js/promotores/formulario.js') }}"></script>
@stop

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
                <form action="{{ url('promotores/procesar') }}" method="post">
                    <fieldset>
                        <div class="col-md-12">
                            <h4>Datos personales</h4>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group {{ $errors->has('Cedula') ? 'has-error' : '' }}">
                                <label class="control-label" for="Cedula">* Documento </label>
                                <input type="text" name="Cedula" class="form-control" value="{{ $persona ? $persona['Cedula'] : old('Cedula') }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group {{ $errors->has('Id_TipoDocumento') ? 'has-error' : '' }}">
                                <label class="control-label" for="Id_TipoDocumento">* Tipo documento </label>
                                <select name="Id_TipoDocumento" id="" class="form-control" data-value="{{ $persona ? $persona['Id_TipoDocumento'] : old('Id_TipoDocumento') }}" title="Seleccionar">
                                    @foreach($documentos as $documento)
                                        <option value="{{ $documento['Id_TipoDocumento'] }}">{{ $documento['Descripcion_TipoDocumento'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group {{ $errors->has('Fecha_Nacimiento') ? 'has-error' : '' }}">
                                <label class="control-label" for="Fecha_Nacimiento">* Fecha de nacimiento </label>
                                <input type="text" name="Fecha_Nacimiento" data-role="datepicker" class="form-control" value="{{ $persona ? $persona['Fecha_Nacimiento'] : old('Fecha_Nacimiento') }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 {{ $errors->has('Id_Genero') ? 'has-error' : '' }}">
                            <div class="form-group">
                                <label class="control-label" for="Id_Genero">* Género</label><br>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default {{ ($persona && $persona['Id_Genero'] == '1') || old('Id_Genero') == '1' ? 'active' : '' }}">
                                        <input type="radio" name="Id_Genero" value="1" autocomplete="off" {{ ($persona && $persona['Id_Genero'] == '1') || old('Id_Genero') == '1' ? 'checked' : '' }}> <span class="text-success">M</span>
                                    </label>
                                    <label class="btn btn-default {{ $persona && ($persona['Id_Genero'] == '2') || old('Id_Genero') == '2' ? 'active' : '' }}">
                                        <input type="radio" name="Id_Genero" value="2" autocomplete="off" {{ $persona && ($persona['Id_Genero'] == '2') || old('Id_Genero') == '2' ? 'checked' : '' }}> <span class="text-danger">F</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group {{ $errors->has('Primer_Nombre') ? 'has-error' : '' }}">
                                <label class="control-label" for="Primer_Nombre">* Primer nombre </label>
                                <input type="text" name="Primer_Nombre" class="form-control" value="{{ $persona ? $persona['Primer_Nombre'] : old('Primer_Nombre') }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="Segundo_Nombre">Segundo nombre </label>
                                <input type="text" name="Segundo_Nombre" class="form-control" value="{{ $persona ? $persona['Segundo_Nombre'] : old('Segundo_Nombre') }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group {{ $errors->has('Primer_Apellido') ? 'has-error' : '' }}">
                                <label class="control-label" for="Primer_Apellido">* Primer apellido </label>
                                <input type="text" name="Primer_Apellido" class="form-control" value="{{ $persona ? $persona['Primer_Apellido'] : old('Primer_Apellido') }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="Segundo_Apellido">Segundo apellido </label>
                                <input type="text" name="Segundo_Apellido" class="form-control" value="{{ $persona ? $persona['Segundo_Apellido'] : old('Segundo_Apellido') }}">
                            </div>
                        </div>
                        <div class="col-xs-12"><hr></div>
                        <div class="col-md-12">
                            <h4>Otros datos</h4>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group {{ $errors->has('Id_Etnia') ? 'has-error' : '' }}">
                                <label class="control-label" for="Id_Etnia">* Etnia </label>
                                <select name="Id_Etnia" id="" class="form-control" data-value="{{ $persona ? $persona['Id_Etnia'] : old('Id_Etnia') }}" title="Seleccionar">
                                    @foreach($etnias as $etnia)
                                        <option value="{{ $etnia['Id_Etnia'] }}">{{ $etnia['Nombre_Etnia'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group {{ $errors->has('Id_Pais') ? 'has-error' : '' }}">
                                <label class="control-label" for="Id_Pais">* País </label>
                                <select name="Id_Pais" id="" class="form-control" data-value="{{ $persona ? $persona['Id_Pais'] : old('Id_Pais') }}" data-live-search="true" title="Seleccionar">
                                    @foreach($paises as $pais)
                                        <option value="{{ $pais['Id_Pais'] }}">{{ $pais['Nombre_Pais'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="Nombre_Ciudad">Ciudad </label>
                                <select name="Nombre_Ciudad" id="" class="form-control" data-value="{{ $persona ? $persona['Nombre_Ciudad'] : old('Nombre_Ciudad') }}" data-live-search="true" title="Seleccionar">
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <hr>
                        </div>
                        <div class="col-xs-12">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="Id_Persona" value="{{ $persona ? $persona['Id_Persona'] : old('Id_Persona', '0') }}">
                            <button id="guardar" type="submit" class="btn btn-primary">Guardar</button>
                            @if ($persona && $persona->promotor)
                                <a data-toggle="modal" data-target="#modal-eliminar" class="btn btn-danger">Eliminar</a>
                            @endif
                            <a href="{{ url('promotores') }}" class="btn btn-default">Volver</a>
                        </div>
                        <div class="col-xs-12"><br></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($persona)
    <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>Realmente desea eliminar este usuario.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('promotores/'.$persona['Id_Persona'].'/eliminar') }}" class="btn btn-danger">Eliminar</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endif
