
@extends('master-formularios', ['titulo' => 'Reservar clase', 'seccion' => 'Beneficiarios'])

@section('content') 
    <div class="content">
        <div id="main">
            <div class="row">
                <form action="{{ url('guardar_clases') }}" method="post">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Agendar clase</h4>
                            </div>
                            <div class="col-md-12">
                                <p>Selecciona un escenario, promotor y la fecha en que deseas recibir y haz click en verificar para validar la disponibilidad.</p>
                            </div>
                        </div>
                        @if (!empty($errors->all()))
                            <div class="row">
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
                            </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('escenario') ? 'has-error' : '' }}">
                                <label>Escenario</label>
                                <select class="form-control selectpicker" title="Seleccionar" data-size="7" data-live-search="true" id="escenario" name="escenario" data-value="{{ old('escenario') ? old('escenario') : '' }}">
                                    @foreach ($elementos as $escenarios)
                                        <option value="{{ $escenarios['Id_Escenario'] }}">{{ $escenarios['Nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('promotores') ? 'has-error' : '' }}"">
                                <label>Promotor</label>
                                <select class="form-control selectpicker" id="promotores" name="promotores" title="Seleccionar" data-live-search="true" data-size="7" data-value="{{ old('promotores') ? old('promotores') : '' }}">
                                </select>
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('fecha') ? 'has-error' : '' }}"">
                                <label>Fecha</label>
                                <input type="text" name="fecha" id="fecha" class="form-control" autocomplete="off" value="{{ old('fecha') ? old('fecha') : '' }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2 ">
                                <input type="button" id="consultar_horarios" class="btn btn-primary" value="Verificar disponibilidad"> 
                            </div>
                        </div>
                        <div class="row" id="agendar" style="display:none;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-4 {{ $errors->has('hora') ? 'has-error' : '' }}"">
                                        <label>Hora</label>
                                        <select class="form-control selectpicker" id="hora" name="hora" title="Seleccionar" value="{{ old('hora') ? old('hora') : '' }}">
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="margin-top:35px;" id="mensaje"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="hidden" id="id_beneficiario" name="id_beneficiario" value="{{ $beneficiario->Id_Beneficiario }}">
                                        <input type="hidden" name="_method" value="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button id="guardar" type="submit" class="btn btn-primary">Agendar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12"><br></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@stop
@section('script')
    @parent
    <script>
        $(function(){
            $('#fecha').datepicker({
                dateFormat: 'yy-mm-dd',
		  	    yearRange: "-80:+20",
                minDate: '+0d', // your min date
                maxDate: '+1d'
            })

            $('#fecha, #promotores').on('change', function(e) 
            {
                $('#hora').html('');
                $('#hora').selectpicker('refresh');
            });

            $('select[name="escenario"]').on('change',function (e) 
            {    
                $('#hora').html('');
                $('#hora').selectpicker('refresh');
                
                if($(this).val() != ""){
                    var url = "{{url('consultar_promotor') }}";
                    var post = $.post(
                        url,
                        {
                            id_escenario : $(this).val()
                        },
                        'json'
                    ).done(function(data){
                        $('#promotores').html('');
                        var opciones = '';
                        if(data){
                            $.each(data, function(i, e){
                                opciones += '<option value="'+e.Id_Promotor+'">'+e.persona['Primer_Nombre']+' '+e.persona['Segundo_Nombre']+' '+e.persona['Primer_Apellido']+' '+e.persona['Segundo_Apellido']+'</option>';
                            });

                            $('#promotores').append(opciones);
                            $('#promotores').selectpicker('refresh');
                            $('select[name="promotores"]').val($('select[name="promotores"]').data('value')).trigger('change');
                        }
                    });
                }
            });

            $('#consultar_horarios').on('click',function (e) {
                if($('#escenario').val() != "" &&  $('#promotores').val() != ""  &&  $('#fecha').val() !=  ""){

                    var url = "{{ url('consultar_disponibilidad') }}";

                    var post = $.post(
                        url,
                        {
                            id_escenario : $('#escenario').val(),
                            id_beneficiario : $('#id_beneficiario').val(),
                            id_promotor : $('#promotores').val(),
                            fecha : $('#fecha').val()
                        },
                        'json'
                    ).done(function(data){
                        var options = '';
                        $.each(data.horas, function(i, v) {
                            horas_disponibles = 0;
                            if(v <= 3) {
                                horas_disponibles ++;
                                options += '<option value="'+i+'" data-subtext="'+(3 - v) +' cupos disponibles">'+(i < 10 ? '0'+i : i)+':00</option>';
                            } else {
                                options += '<option value="'+i+'" disabled data-subtext="Completo">'+(i < 10 ? '0'+i : i)+':00</option>';
                            }

                            if(horas_disponibles > 0)
                            {
                                if(data.status == 100)
                                    $('#mensaje').text('Selecciona uno de los horarios.');
                                else
                                    $('#mensaje').text('Parece que ya tienes una clase agendada este dia, selecciona otra hora para reagendarla.');
                            } else {
                                $('#mensaje').text('Parece que los cupos de este promotor el dia seleccionado estan completos, prueba con otra fecha o promotor.');
                            }

                            $('#hora').html(options);
                            $('#hora').selectpicker('refresh');

                            $('#agendar').show();
                        });
                    });
                }
            });

            $('select[name="escenario"]').val($('select[name="escenario"]').data('value')).trigger('change');
        });
    </script>

@stop