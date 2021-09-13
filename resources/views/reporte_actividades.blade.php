@extends('master-formularios')
@section('content')
<div class="content">
    <div id="main" class="row">
        <div class="col-md-12"><br></div>
		<div class="col-md-12">
			<div class="row">
				<form action="{{ url('/reporte_actividades') }}" method="post">
					<div class="col-md-12">
						<div class="row">
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
								<input type="submit" name="accion" class="btn btn-primary" value="consultar">
								<input type="submit" name="accion" class="btn btn-success" value="exportar">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			@if($actividades)
				<table class="table table-min">
					<thead>
						<tr>
							<th>Id</th>
							<th>Fecha</th>
							<th>Promotor</th>
							<th>Nombre</th>
							<th>Empresa</th>
							<th>Tipo</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($actividades as $actividad)
							<tr>
								<td>{{ $actividad->Id_Actividad }}</td>
								<td>{{ $actividad->Fecha }}</td>
								<td>{{ $actividad->promotor->persona->Primer_Nombre }} {{ $actividad->promotor->persona->Primer_Apellido }}</td>
								<td>{{ $actividad->Nombre_Del_Evento }}</td>
								<td>{{ $actividad->Empresa }}</td>
								<td>{{ $actividad->Tipo }}</td>
								<td><a target="_blank" href="{{ url('/actividades/formulario/'.$actividad->Id_Actividad) }}"><i class="fa fa-pencil"></i></a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
    </div>
</div>
@stop
@section('script')
    @parent
    <script>
		$(function() {
			$('table').DataTable();
		})
	</script>
@stop