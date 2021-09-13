@extends('master-formularios', ['titulo' => 'Cancelar clase', 'seccion' => 'Cancelar clase'])                              

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
                    <h4>Cancelar clase</h4>
                </div>
                <div class="col-md-12">
                    <p>Para cancelar una clase por favor seleccione la clase y haz click en eliminar.</p>
                </div>
            </div>
            <div class="row">
                @if (count($clases) > 0)
                    <div class="col-xs-12">
                        <table class="default display no-wrap responsive table table-min table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        Fecha.
                                    </th>
                                    <th style="width: 50px;">
                                        Hora.
                                    </th>
                                    <th >
                                        Promotor.
                                    </th>
                                    <th >
                                        Escenario.
                                    </th>
                                    
                                    <th data-priority="2" class="no-sort" style="width: 30px;">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clases as $clase)
                                    <tr>
                                        <td style="text-align: center;" width=60>
                                            {{ $clase->Fecha }}
                                        </td>
                                        <td style="text-align: center;" width=60>
                                            {{ str_pad($clase->Hora, 2, '0', STR_PAD_LEFT).':00' }}
                                        </td>
                                        <td style="text-align: center;" width=60>
                                            {{ $clase->promotor->persona['Primer_Nombre'].' '.$clase->promotor->persona['Segundo_Nombre'].' '.$clase->promotor->persona['Primer_Apellido'].' '.$clase->promotor->persona['Segundo_Apellido'] }}
                                        </td>
                                        <td style="text-align: center;" width=60>
                                            {{ $clase->escenario['Nombre'] }}
                                        </td>
                                        
                                        <td>
                                            <a href="{{ url('eliminar_clase/'.$clase->Id_Asistencia) }}" class="pull-right btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            
	    </div>
	</div>
@stop
@section('script')
    @parent
    <script>
        $(function(){

            $('.mensaje').css('display', 'none');

            
        });
    </script>

@stop