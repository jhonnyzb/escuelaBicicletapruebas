@extends('master-formularios', ['titulo' => 'Inscripción', 'seccion' => 'Inscripción'])                              

@section('content') 
	<div class="content">
	    <div id="main" class="row" data-url="{{ url('personas') }}" data-url-modulo="{{ url('promotores') }}">
	        @if ($status == 'success')
                <div class="row">
                    <div id="alerta" class="col-xs-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Datos actualizados satisfactoriamente.
                        </div>
                    </div>
                </div>
	        @endif
            <div class="row">
                <div class="col-md-12">
                    <h4>Agenda tu clase</h4>
                </div>
                <div class="col-md-12">
                    <p>Para agendar una clase por favor ingresa el Nº de identificación de la persona que tomara la clase y haz click en continuar.</p>
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
            <div class="row">
                <div class="col-xs-12"><br></div>
                <div class="col-xs-12 mensaje">
                    <div class="alert alert-info" role="alert">
                        Parece que el documento ingresado no se encuentra registrado en el programa, para registrarte haz click 
                        <strong><a href="{{url('inscripcion') }}">AQUÍ</a></strong>
                    </div>
                </div>
            </div>
	    </div>
	</div>
@stop
@section('script')
    @parent
    <script>
        $(function(){

            $('.mensaje').css('display', 'none');

            $('#consultar_documento').on('click', function(e){
                if($('input[name="documento"]').val() != ""){

                    var url = "{{url('consultar_beneficiario') }}";
                    var post = $.post(
                        url,
                        {
                            documento : $('input[name="documento"]').val()
                        },
                        'json'
                    ).done(function(data){
                        if(data == 1){
                            window.location.href = "{{url('reservar_clase/') }}"+'/'+$('input[name="documento"]').val();
                        }else{
                            $('.mensaje').css('display', 'block');
                        }
                    });
                }
            });
        });
    </script>

@stop