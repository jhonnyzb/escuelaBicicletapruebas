@extends('master-formularios')
@section('content')
<div class="content">
    <div id="main" class="row">
        <div class="col-xs-12"><br></div>
        <div class="col-xs-12">
            Seleccione el perido durante el cual desea generar el reporte.
        </div>
        <div class="col-md-12"><br></div>
        <div class="col-md-12">
            <div class="row">
                <form name="form_busqueda_reporte_consolidado" action="{{ url('reporte_consolidado') }}" method="post">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="">Desde</label>
                                <input name="fechai" type="text" placeholder="Desde" class="form-control" data-role="datepicker" data-rel="fecha_inicio" data-fecha-inicio="" data-fecha-fin="" data-fechas-importantes="{{ Festivos::create()->datesToString() }}" value="{{ old('desde') }}">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="">Hasta</label>
                                <input name="fechaf" type="text" placeholder="Hasta" class="form-control" data-role="datepicker" data-rel="fecha_fin" data-fecha-inicio="" data-fecha-fin="" data-fechas-importantes="{{ Festivos::create()->datesToString() }}" value="{{ old('hasta') }}">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="">&nbsp;</label><br>
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-success">Consultar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12"><hr></div>
        <div class="col-xs-12"><br></div>
        <div class="col-md-12">
            <table class="datatable display no-wrap responsive table table-min table-striped" width="100%">
            <thead>
                <tr>
                    <th class="all">id</th>
                    <th class="all">Escenario</th>
                    <th class="all">Mes</th>
                    <th class="all">Total</th>
                </tr>
            </thead>
            <tbody>
                @if($datos)
                    @foreach($datos as $registro)
                        @foreach($registro['jornadas'] as $key => $jornadas)
                            @php
                                $participantes = 0;
                                foreach ($jornadas as $jornada) {
                                    $participantes += $jornada->usuarios->count();
                                }
                            @endphp
                            <tr>
                                <td>{{ $registro['escenario']->Id }}</td>
                                <td>{{ $registro['escenario']->Nombre }}</td>
                                <td>{{ $key }}</td>
                                <td>{{ $participantes }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th class="all">id</th>
                    <th class="all">Escenario</th>
                    <th class="all">Mes</th>
                    <th class="all">Total</th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
</div>
@stop
@section('script')
    @parent
    <script src="{{ asset('public/Js/reporte.js') }}"></script>
@stop
