@extends('master-formularios')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <br><br><br><br><br><br>
            </div>
            @if ($status == 'sin terminar')
                <div id="alerta" class="col-md-6 col-md-offset-3">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        El usuario registrado con ese número de documento no ha completado el programa.
                    </div>
                </div>
            @endif
            @if (!empty($errors->all()))
                <div class="col-md-6 col-md-offset-3">
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
            @endif
            <div class="form-group col-md-6 col-md-offset-3">
                <h4>Diploma virtual</h4>
            </div>
            <form action="{{ url('certificado') }}" method="post">
                <div class="form-group col-md-6 col-md-offset-3">
                    <label for="">Documento:</label>
                    <input type="text" name="documento" class="form-control">
                </div>
                <div class="col-md-6 col-md-offset-3" style="text-align:center;">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generar</button>
                </div>
            </form>
            <div class="col-md-12">
                <br><br><br><br><br><br>
            </div>
        </div>
    </div>
@stop
