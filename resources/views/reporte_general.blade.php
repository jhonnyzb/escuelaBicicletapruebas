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
                <form name="form_reporte_general_2" action="reporte_general_2" method="post">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="">Desde</label>
                                <input name="fechai" type="text" placeholder="Desde" class="form-control" data-role="datepicker" data-rel="fecha_inicio" data-fecha-inicio="" data-fecha-fin=""  value="{{ old('desde') }}">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="">Hasta</label>
                                <input name="fechaf" type="text" placeholder="Hasta" class="form-control" data-role="datepicker" data-rel="fecha_fin" data-fecha-inicio="" data-fecha-fin=""  value="{{ old('hasta') }}">
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
    </div>
</div>
@stop
@section('script')
    @parent
    <script src="{{ asset('public/Js/reporte_general.js') }}?v=5"></script>
@stop
