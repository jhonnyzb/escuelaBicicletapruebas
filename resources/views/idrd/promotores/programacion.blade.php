@extends('master-formularios', ['titulo' => 'Programación promotores', 'seccion' => 'Programación promotores'])                              

@section('content') 
    <div class="content">
        <div id="main" class="row" data-url="{{ url('programacion') }}">
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
                <form id="programacion_promotores_consulta" action="{{ url('programacion_promotores_consulta') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-12">
                        <h4>Consultar programación promotores</h4>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="">Fecha</label>
                        <input name="fecha" type="text" required placeholder="seleccionar" class="form-control" data-role="datepicker" value="{{ old('fecha') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Promotor</label>
                        <select class="form-control selectpicker" required id="promotor" data-actions-box="true" name="promotor"  title="Seleccionar" data-live-search="true" data-size="7">
                            @foreach($promotores as $promotor)
                                <option value="{{ $promotor->Id_Promotor }}">{{ $promotor->persona['Primer_Nombre'].' '.$promotor->persona['Segundo_Nombre'].' '.$promotor->persona['Primer_Apellido'].' '.$promotor->persona['Segundo_Apellido'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 col-xs-12">
                        <input type="submit"  class="btn btn-info" value="Consultar">
                    </div>
                </form>
            </div>
            <div class="row">
                @if (count($clases) > 0)
                    <div class="col-xs-12">
                        <table class="default display no-wrap responsive table table-min table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th >
                                        Escenario.
                                    </th>
                                    <th style="width: 50px;">
                                        Fecha.
                                    </th>
                                    <th style="width: 50px;">
                                        Hora.
                                    </th>
                                    <th >
                                        Beneficiario.
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clases as $clase)
                                    <tr>
                                        <td style="text-align: center;" width=60>
                                            {{ $clase->escenario['Nombre'] }}
                                        </td>
                                        <td style="text-align: center;" width=60>
                                            {{ $clase->Fecha }}
                                        </td>
                                        <td style="text-align: center;" width=60>
                                            {{ str_pad($clase->Hora, 2, '0', STR_PAD_LEFT).':00' }}
                                        </td>
                                        <td style="text-align: center;" width=60>
                                            {{ $clase->beneficiario['Nombre']  }}
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
            
        });
    </script>

@stop


