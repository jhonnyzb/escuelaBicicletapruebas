@extends('master-formularios', ['titulo' => 'Escenarios', 'seccion' => 'Escenarios'])                              

@section('content') 
    <div class="content">
        <div id="main" class="row" data-url="{{ url('promotores') }}">
            @if ($status == 'success')
                <div id="alerta" class="col-xs-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Datos actualizados satisfactoriamente.
                    </div>                                
                </div>
            @endif
            <div class="col-xs-12">
                <a class="btn btn-primary" href="{{ url('escenarios/crear') }}">Crear</a>
            </div>
            <div class="col-xs-12"><br></div>
            <div class="col-xs-12">
                 <table class="default display no-wrap responsive table table-min table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>
                                Cod.
                            </th>
                            <th>
                                Escenario
                            </th>
                            <th>
                                Localidad
                            </th>
                            <th>
                                # Actividades
                            </th>
                            <th data-priority="2" class="no-sort" style="width: 30px;">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($elementos as $escenario)
                            <tr>
                                <td style="text-align: center;" width=60>
                                    {{ $escenario->getCode() }}
                                </td>
                                <td>
                                    {{ $escenario->Nombre }}
                                </td>
                                <td>
                                    {{ $escenario->localidad['Localidad'] }}
                                </td>
                                <td>
                                    {{ $escenario->jornadas->count() }}
                                </td>
                                <td>
                                    <a href="{{ url('escenarios/'.$escenario['Id_Escenario'].'/editar') }}" class="pull-right btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Editar">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </ul>
            </div>
        </div>
    </div>
@stop
