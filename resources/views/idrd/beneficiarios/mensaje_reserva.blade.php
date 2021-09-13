@extends('master-formularios', ['titulo' => 'Reserva', 'seccion' => 'Reserva'])                              

@section('content') 
	<div class="content">
        <div class="row">
            <div class="col-xs-12"><br></div>
            <div class="row">
                <div class="col-md-6 mensaje col-md-offset-3">
                    <div class="alert alert-info" role="alert">
                        Su clase fue agendada con exito!.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h4>Agradecemos el interés de su participación en la Escuela de la Bicicleta, aquí encontrará un breve resumen de la información de su clase:</h4>
                    <strong>Nombre de persona que tomará la clase:</strong> {{ $destinatario }}<br>
                    <strong>No. de identificación de la persona que tomará la clase:</strong> {{ $documento }}<br>
                    <strong>Nombre del Acudiente:</strong> {{ $acudiente }}<br>
                    <strong>Día:</strong> {{ $dia }}<br>
                    <strong>Hora:</strong> {{ str_pad($hora, 2, '0', STR_PAD_LEFT).':00' }}<br>
                    <strong>Parque:</strong> {{ $parque }}
                    <br><br>
                    Recuerde asistir al punto de Escuela de la Bicicleta (Contenedor color rojo) ubicado dentro del escenario, haciendo uso de tapabocas en todo momento, siempre tapando nariz, boca y mentón. 
                </div>
            </div>
        </div>
	</div>
@stop