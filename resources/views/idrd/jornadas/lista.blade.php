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
        <div class="col-xs-12"><br></div>
        <div class="col-xs-12">
            Total de jornadas encontradas: {{ count($elementos) }}
        </div>
        <div class="col-md-12"><br></div>
        <form action="{{ url('/jornadas') }}" method="post">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label for="">Lugar</label>
                        <select name="parque" id="parque" title="Seleccionar" class="form-control" data-value="{{ old('parque') }}">
                            <option value="Todos">TODOS</option>
                            @foreach($parques as $parque)
                                <option value="{{ $parque['Id'] }}">{{ $parque['Nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="">Desde</label>
                        <input name="desde" type="text" placeholder="Desde" class="form-control" data-role="datepicker" data-rel="fecha_inicio" data-fecha-inicio="" data-fecha-fin="" data-fechas-importantes="{{-- Festivos::create()->datesToString() --}}" value="{{ old('desde') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="">Hasta</label>
                        <input name="hasta" type="text" placeholder="Hasta" class="form-control" data-role="datepicker" data-rel="fecha_fin" data-fecha-inicio="" data-fecha-fin="" data-fechas-importantes="{{-- Festivos::create()->datesToString() --}}" value="{{ old('hasta') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="">&nbsp;</label><br>
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-xs-12"><hr></div>
        <div class="col-xs-12"><br></div>
        @if (count($elementos) > 0)
            <div class="col-xs-12">
                 <table class="default display no-wrap responsive table table-min table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 90px;">
                                Cod.
                            </th>
                            <th style="width: 90px;">
                                Fecha
                            </th>
                            <th style="width: 90px;">
                                Tipo
                            </th>
                            <th style="width: 90px;">
                                Localidad
                            </th>
                            <th>
                                Parque / Lugar
                            </th>
                            <th style="width: 90px;">
                                # Usuarios
                            </th>
                            <th data-priority="2" class="no-sort" style="width: 30px;">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($elementos as $jornada)
                            <tr>
                                <td style="text-align: center;" width=60>
                                    {{ $jornada->getCode() }}
                                </td>
                                <td>
                                    {{ $jornada->Fecha }}
                                </td>
                                <td>
                                    {{ $jornada->Tipo }}
                                </td>
                                <td>
                                    {{ $jornada->Id_Localidad == 0 ? 'No aplica' : $jornada->localidad['Localidad'] }}
                                </td>
                                <td>
                                    {{ $jornada->Id_Parque == 0 ? '' : $jornada->escenario['Nombre'] }}
                                </td>
                                <td>
                                    {{ $jornada->usuarios->count() }}
                                </td>
                                <td>
                                    <a href="{{ url('jornadas/formulario/'.$jornada->Id_Jornada) }}" class="pull-right btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Editar">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
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
