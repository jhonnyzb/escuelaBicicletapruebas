@extends('master-formularios', ['titulo' => 'Inscripciones', 'seccion' => 'Beneficiarios'])

@section('content') 
    <div class="content">
        <div id="main">
            <div class="row">
                <form action="{{ url('inscripcion_beneficiarios') }}" method="post">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Inscripción</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Datos personales</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Id_Documento') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Id_Documento">* Tipo documento</label>
                                    <select name="Id_Tipo_Documento" id="Id_Tipo_Documento" class="form-control" title="Seleccionar" data-value="{{ old('Id_Tipo_Documento') ? old('Id_Tipo_Documento') : '' }}">
                                        @foreach($documentos as $documento)
                                            <option value="{{ $documento['Id_TipoDocumento'] }}">{{ strtoupper($documento['Descripcion_TipoDocumento']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Documento') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Documento">* Nº documento</label>
                                    <input type="text" name="Documento" class="form-control" value="{{ old('Documento') ? old('Documento') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('Nombre') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Nombre">* Nombre</label>
                                    <input type="text" name="Nombre" class="form-control" value="{{ old('Nombre') ? old('Nombre') : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Fecha_Nacimiento') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Fecha_Nacimiento">* Fecha nacimiento</label>
                                    <input type="text" name="Fecha_Nacimiento" data-role="datepicker" class="form-control" value="{{ old('Fecha_Nacimiento') ? old('Fecha_Nacimiento') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Id_Genero') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Fecha_Nacimiento">* Genero</label> <br>
                                    <label class="radio-inline">
                                        <input type="radio" name="Id_Genero" id="inlineRadio1" value="1" {{  old('Id_Genero') == '1' ? 'checked' : '' }}> M
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="Id_Genero" id="inlineRadio2" value="2" {{  old('Id_Genero') == '2' ? 'checked' : '' }}> F
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="Id_Genero" id="inlineRadio3" value="3" {{  old('Id_Genero') == '3' ? 'checked' : '' }}> Intersexual
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Genero_Poblacional') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Genero_Poblacional">* Grupo poblacional</label>
                                    <select name="Genero_Poblacional" id="Genero_Poblacional" class="form-control" title="Seleccionar" data-value="{{ old('Genero_Poblacional') ? old('Genero_Poblacional') : '' }}">
                                        @foreach($grupos as $grupo)
                                            <option value="{{ $grupo['id'] }}">{{ strtoupper($grupo['nombre']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Discapacidad') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Discapacidad">Discapacidad</label>
                                    <select name="Discapacidad" id="Discapacidad" title="Seleccionar" class="form-control" data-value="{{ old('Discapacidad') ? old('Discapacidad') : '' }}">
                                        <option value="">NINGUNA</option>
                                        @foreach($discapacidades as $discapacidad)
                                            <option value="{{ $discapacidad['id'] }}">{{ strtoupper($discapacidad['discapacidad']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Id_Localidad') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Id_Localidad">* Localidad</label>
                                    <select name="Id_Localidad" id="Id_Localidad" title="Seleccionar" class="form-control" data-value="{{ old('Id_Localidad') ? old('Id_Localidad') : '' }}" data-live-search="true" data-size=10>
                                        @foreach($localidades as $localidad)
                                            <option value="{{ $localidad['Id_Localidad'] }}">{{ strtoupper($localidad['Localidad']) }}</option>
                                        @endforeach
                                            <option value="otro">OTRO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 oculto_municipio">
                                <div class="form-group {{ $errors->has('Municipio') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Municipio">Municipio</label>
                                    <input type="text" name="Municipio" class="form-control" value="{{ old('Municipio') ? old('Municipio') : '' }}">
                                </div>
                            </div>
                            <div class="oculto_upz">
                                <div class="col-md-3">
                                    <div class="form-group {{ $errors->has('Id_Upz') ? 'has-error' : '' }}">
                                        <label class="control-label" for="Id_Upz">* UPZ</label>
                                        <select name="Id_Upz" id="Id_Upz" title="Seleccionar" class="form-control" data-value="{{ old('Id_Upz') ? old('Id_Upz') : '' }}" data-live-search="true" data-size=10>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ $errors->has('Id_Barrio') ? 'has-error' : '' }}">
                                        <label class="control-label" for="Id_Barrio">Barrio</label>
                                        <select name="Id_Barrio" id="Id_Barrio" title="Seleccionar" class="form-control" data-value="{{ old('Id_Barrio') ? old('Id_Barrio') : '' }}" data-live-search="true" data-size=10>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Estrato') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Estrato">Estrato</label>
                                    <select name="Estrato" id="Estrato" title="Seleccionar" class="form-control" data-value="{{ old('Estrato') ? old('Estrato') : '' }}" data-size=10>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Datos de contacto</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('Correo') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Correo">* Correo</label>
                                    <input type="text" name="Correo" class="form-control" value="{{ old('Correo') ? old('Correo') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Telefono') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Telefono">* Nº Teléfono / Celular</label>
                                    <input type="text" name="Telefono" class="form-control" value="{{ old('Telefono') ? old('Telefono') : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Acudiente <small>(Son requeridos para menores de edad)</small></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Tipo_Documento_Acudiente') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Tipo_Documento_Acudiente">* Tipo documento</label>
                                    <select name="Tipo_Documento_Acudiente" id="Tipo_Documento_Acudiente" class="form-control" title="Seleccionar" data-value="{{ old('Tipo_Documento_Acudiente') ? old('Tipo_Documento_Acudiente') : '' }}">
                                        @foreach($documentos as $documento)
                                            <option value="{{ $documento['Id_TipoDocumento'] }}">{{ strtoupper($documento['Descripcion_TipoDocumento']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('Documento_Acudiente') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Documento_Acudiente">* Nº documento</label>
                                    <input type="text" name="Documento_Acudiente" class="form-control" value="{{ old('Documento_Acudiente') ? old('Documento_Acudiente') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('Nombre_Acudiente') ? 'has-error' : '' }}">
                                    <label class="control-label" for="Nombre_Acudiente">* Nombre</label>
                                    <input type="text" name="Nombre_Acudiente" class="form-control" value="{{ old('Nombre_Acudiente') ? old('Nombre_Acudiente') : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                * Al hacer click en el botón registrar estoy consciente de que firmo y acepto la <strong><a href="{{ asset('public/autorizacion_y_consentimiento_informado_escuela_de_la_bicicleta.pdf') }}" target="_blank">AUTORIZACIÓN Y CONSENTIMIENTO INFORMADO DE LA ESCUELA DE LA BICICLETA.</a></strong>
                            </div>
                        </div>
                        <div class="row">
                        <br>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button id="guardar" type="submit" class="btn btn-primary">Registrarme</button>
                            </div>
                        </div>
                        <div class="col-xs-12"><br></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div id="modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Información</h4>
            </div>
            <div class="modal-body">
                <p>
                El Instituto Distrital de Recreación y Deporte ha decidido brindar acceso controlado a la ciudadanía en los servicios que ofrece el programa Escuela de la Bicicleta respetando y cumpliendo la Resolución 666 del 24 abril de 2020 del Ministerio de Salud y la Protección Social “Por medio de la cual se adopta el protocolo general de bioseguridad para mitigar, controlar y realizar el adecuado manejo de la pandemia del Coronavirus COVID-19”. Dada la situación actual de riesgo y el interés por brindar alternativas de esparcimiento, práctica de actividad física mediante el uso de la bicicleta y fomento de hábitos de vida saludable en la ciudad de Bogotá.
                <br><br>
                Con el fin de minimizar el riesgo de contagio, y evitar aglomeraciones en las clases de la Escuela de la bicicleta, estás se impartirán por periodos de una hora, cada profesor atenderá hasta 3 personas por hora, desinfectado elementos de contacto compartido entre una sesión y otra.
                <br><br>
                Las personas interesadas en participar deben leer y diligenciar completamente este formulario, y cumplir con el protocolo de bioseguridad dispuesto para la Escuela de la Bicicleta e ingresar al escenario usando tapabocas cubriendo boca, barbilla y nariz en todo momento, no se permite el uso de buff o bufanda para reemplazar el tapabocas. 
                <br><br>
                Tenga en cuenta que si presenta síntomas de COVID-19 como fiebre, tos, gripa, dolor de garganta, dificultad respiratoria, cansancio, malestar general, dificultad para percibir el gusto o el olfato absténganse de inscribirse. 
                <br><br>
                ¡Cuídate, cuídanos y cuidemos de todos y todas!<br><br>
                <strong>ANTES DE INCRIBIRSE LEA ATENTAMENTE ESTA INFORMACIÓN:</strong>
                </p>
                <br>
                <ul>
                    <li>Debe asistir a la clase con un Kit de bioseguridad básico que compone: Gel antibacterial contenido mínimo de 30 ml, Alcohol de concentración al 70%, contenido mínimo de 50 ml, un tapabocas de repuesto y una toallita limpia. </li>
                    <li>Es obligatorio el uso tapabocas durante el desarrollo de toda la actividad.</li>
                    <li>Evite el contacto o interacción con otras personas ajenas a su hogar.</li>
                    <li>Debe mantener siempre el distanciamiento de al menos 2 metros.</li>
                    <li>Debe llevar su propio casco para la clase.</li>
                    <li>Verifique su asistencia y cumplimiento de horario al que se inscribió, de no asistir a la hora programada podría perder su turno.</li>
                    <li>Atienda las recomendaciones impartidas por los profesores de la Escuela de la Bicicleta.</li>
                    <li>En el caso que se presenten lluvias NO se prestará el servicio de Escuela de la bicicleta.</li>
                    <li>Haga uso de protección solar, Lleve su propia hidratación y comida, absténgase de comprar comida en puestos ambulantes, así como compartir estos elementos con los demás participantes.</li>
                    <li>Las personas deben tener más de 4 años para asistir a la Escuela de la bicicleta.</li>
                    <li>Recuerde tener cobertura vigente en el sistema de salud.</li>
                    <li>Elementos como papel higiénico y tapabocas, evite desecharlos al interior del parque.</li>
                    <li>Está prohibido escupir en el en los espacios del parque y la actividad, como parte de la prevención y el cuidado mutuo.</li>
                    <li>Recuerda realizar una desinfección adecuada del calzado y elementos de la práctica recreativa luego de finalizar esta actividad al llegar a casa.</li>
                    <li>Recuerde que al inscribirse adquiere un compromiso de asistencia a los servicios de la Escuela de la bicicleta, su inasistencia puede perjudicar la prestación del servicio.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@stop

@section('script')
@parent
    <script>
        $(function() {
            $('#modal').modal('show');
            $('#Id_Localidad').on('change', function(e) 
            {
                if($(this).val() != 'otro'){

                    $('.oculto_municipio').css('display', 'none');
                    $('.oculto_upz').css('display', 'block');

                    var request = $.post('{{ url("/upz") }}', {
                        Id_Localidad: $(this).val()
                    });

                    request.done(function(data) {
                        var options = '';
                        $.each(data, function(i, e) {
                            options += '<option value="'+e.Id_Upz+'">'+e.Upz+'</option>';
                        });

                        $('#Id_Upz').html(options);
                        $('#Id_Upz').selectpicker('refresh');
                        $('#Id_Upz').val($('#Id_Upz').data('value')).trigger('change');
                    });
                }else if($(this).val() == 'otro'){
                    $('.oculto_municipio').css('display', 'block');
                    $('.oculto_upz').css('display', 'none');
                }

            });

            $('.oculto_municipio').css('display', 'none');

            $('#Id_Upz').on('change', function(e) 
            {
                if($(this).val() != ''){
                    var request = $.post('{{ url("/barrios") }}', {
                        Id_Upz: $(this).val()
                    });

                    request.done(function(data) {
                        var options = '';
                        $.each(data, function(i, e) {
                            options += '<option value="'+e.IdBarrio+'">'+e.Barrio+'</option>';
                        });

                        $('#Id_Barrio').html(options);
                        $('#Id_Barrio').selectpicker('refresh');
                        $('#Id_Barrio').val($('#Id_Barrio').data('value')).trigger('change');
                    });
                }
            });

            $('#Id_Localidad').val($('#Id_Localidad').data('value')).trigger('change');
        });
    </script>
@stop