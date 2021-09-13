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
                <form name="form_busqueda_reporte" action="fecha_reporte" method="post">
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
                    <th class="all">Localidad</th>
                    <th class="all">Lugar</th>
                    <th class="all">Fecha</th>
                    <th class="none">Clima</th>
                    <th class="all">Encargado</th>
                    <th class="none">Tipo</th>
                    <th class="none">Observaciones</th>
                    <th>Cedula</th>
                    <th class="all">Primer apellido</th>
                    <th class="all">Segundo apellido</th>
                    <th class="all">Primer nombre</th>
                    <th class="all">Segundo nombre</th>
                    <th class="none">Nombre acudiente</th>
                    <th class="none">Email acudiente</th>
                    <th class="none">Teléfono acudiente</th>
                    <th class="none">Nombre usuario</th>
                    <th class="none">Tipo doc.</th>
                    <th class="none">Número doc.</th>
                    <th class="all">Genero</th>
                    <th class="all">Edad</th>
                    <th class="all">CB</th>
                    <th class="all">Hora inicio</th>
                    <th class="all">Hora fin</th>
                    <th class="all">Destreza inicial</th>
                    <th class="all">Avance logrado</th>
                    <th class="none">Observaciones del usuario</th>
                    <th class="all">Registro</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>
@stop
@section('script')
    @parent
    <script src="{{ asset('public/Js/reporte.js') }}?v=5"></script>
@stop
