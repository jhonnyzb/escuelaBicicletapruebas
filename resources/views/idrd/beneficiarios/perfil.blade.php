@extends('master-formularios', ['titulo' => 'miPerfil', 'seccion' => 'miPerfil'])                              

@section('content') 
	<div class="content">
	    <div id="main" class="row" data-url="{{ url('personas') }}" data-url-modulo="{{ url('promotores') }}">
            @if(!$beneficiario)
                <div class="row">
                    <div class="col-md-12">
                        <h4>Mi perfil</h4>
                    </div>
                    <div class="col-md-12">
                        <p>Ingresa el número de documento del beneficiaro a consultar.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Documento</label>
                                <input type="text" class="form-control" name="documento">
                            </div>
                            <div class="col-md-4">
                                <input type="button" class="btn btn-primary" value="Continuar" id="consultar_documento" style="margin-top:25px;">
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4>{{ $beneficiario->Nombre }}</h4>
                            </div>
                        </div>
                    </div>
                    @if($asistencias->count() > 0)
                        <div class="col-xs-12">
                            <div class="list-group">
                                <?php 
                                    $class_count = 0; 
                                    $completo = false;
                                    $niveles = [
                                        0 => '<span class="badge badge-light">A - No sabe montar bicicleta</span>',
                                        1 => '<span class="badge badge-light">B - Pedalea con ruedas de entrenamiento</span>',
                                        2 => '<span class="badge badge-light">C - Camina con la bicicleta</span>',
                                        3 => '<span class="badge badge-warning">D - Se impulsa y mantiene el equilibrio por instantes</span>',
                                        4 => '<span class="badge badge-warning">E - Se impulsa y mantiene el equilibrio</span>',
                                        5 => '<span class="badge badge-warning">F - Pedalea con apoyo</span>',
                                        6 => '<span class="badge badge-success">G - Pedalea y mantiene el equilibrio por instantes</span>',
                                        7 => '<span class="badge badge-success">H - Maneja</span>',
                                        8 => '<span class="badge badge-success">I - Maneja y adquiere otras habilidades sobre la bicicleta</span>'
                                    ];    
                                ?>
                                @foreach($asistencias as $asistencia)
                                    <?php 
                                        $class_count++; 
                                        $completo = (!$completo ? ($asistencia->Nivel_Destreza == 8 ? true : false) : $completo);
                                    ?>
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">Clase {{ $class_count }} {!! $asistencia->Nivel_Destreza ? $niveles[$asistencia->Nivel_Destreza] : '' !!}</h5>
                                            <small>{{ $asistencia->Fecha.' - '.str_pad($asistencia->Hora, 2, '0', STR_PAD_LEFT).':00' }}</small>
                                        </div>
                                        <p class="mb-1">
                                            <strong>Profesor:</strong> {{ $asistencia->promotor->persona->toFriendlyString() }} <br>
                                            <strong>Escenario:</strong> {{ $asistencia->escenario->Nombre }} <br>
                                            <strong>Asistio:</strong> {{ $asistencia->Asistio }} <br>
                                        </p>
                                        <!--<small>Donec id elit non mi porta.</small>-->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12">
                            @if ($completo)
                                <a href="{{ url('certificado') }}" class="btn btn-success" target="_blank">Generar certificado</a>
                            @endif
                                <a href="{{ url('cancelar_clase/'.$beneficiario->Documento) }}" class="btn btn-danger" target="_blank">Cancelar clase</a>
                        </div>
                    @else
                        <div class="col-xs-12">
                            <div class="list-group">
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Parece que aun no tienes avances registrados!</h5>
                                        <small>{{ date('Y-m-d H:i') }}</small>
                                    </div>
                                    <p class="mb-1">
                                        Si lo deseas puedes verificar en un par de días si ya se registro la clase!.
                                    </p>
                                    <!--<small>Donec id elit non mi porta.</small>-->
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            <div class="col-md-12">
                <br>
            </div>
	    </div>
	</div>
@stop
@section('script')
    @parent
    <script>
        $(function(){
            $('.mensaje').css('display', 'none');

            var url = "{{ url('/miPerfil') }}";

            $('#consultar_documento').on('click', function(e){
                location.href = url + '/'+$('input[name="documento"]').val();
            });
        });
    </script>

@stop