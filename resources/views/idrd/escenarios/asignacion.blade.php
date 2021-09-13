@extends('master-formularios', ['titulo' => 'Asignación', 'seccion' => 'º'])                              

@section('content') 
    <div class="content">
        <div id="main" class="row" data-url="{{ url('asignacion') }}">
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
                <form id="formulario_asignacion" action="{{ url('guardar_asignacion') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-12">
                        <h4>Asignar promotores a escenarios</h4>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Escenario</label>
                        <select class="form-control selectpicker"  data-actions-box="true" data-size="7" data-live-search="true" id="escenario" name="escenario" title="Seleccionar" >
                            @foreach ($elementos as $escenarios)
                                <option value="{{ $escenarios['Id_Escenario'] }}">{{ $escenarios['Nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Promotor</label>
                        <select class="form-control selectpicker" id="promotor" data-actions-box="true" name="promotor[]" multiple title="Seleccionar" data-live-search="true" data-size="7">
                            @foreach($promotores as $promotor)
                                <option value="{{ $promotor->Id_Promotor }}">{{ $promotor->persona['Primer_Nombre'].' '.$promotor->persona['Segundo_Nombre'].' '.$promotor->persona['Primer_Apellido'].' '.$promotor->persona['Segundo_Apellido'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 col-xs-12">
                        <input type="submit"  class="btn btn-info" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('script')
    @parent
    <script>
        $(function(){
            $('select[name="escenario"]').on('change',function (e) {

                //var url = "{{url('consultar_escenarios') }}";
                var url = "{{url('consultar_promotores') }}";

                var post = $.post(
                    url,
                    {
                        id_escenario : $(this).val()
                    },
                    'json'
                ).done(function(data){
                    var res = data.map(function(el) {
                        return el * 1;
                    });

                    $('#promotor').selectpicker('val', res);
                });

            });
        });
    </script>

@stop


