@extends('master-formularios')

@section('script')
	@parent
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
	<script>
		$(function() {

			var procesos_anio = {!! json_encode($procesos_anio) !!};
			procesos_anio = procesos_anio.map(function(registro) {
				return {x: registro.x, y: +registro.y};
			});

			var ctx_procesos_anio = $('#procesos_anio');
			var chart_procesos_anio = new Chart(ctx_procesos_anio, {
				type: 'bar',
				data: {
					labels: procesos_anio.map(function(registro) {
						return registro.x;
					}),
					datasets: [{
						data: procesos_anio.map(function(registro) {
							return +registro.y;
						}), 
						backgroundColor: procesos_anio.map(function(registro) {
							return 'rgba(69, 39, 160, 0.5)';
						}),
						label: '# de procesos.',
					}]
				},
				options: {
                    maintainAspectRatio: false,
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

			var aprendieron_a_montar = {!! json_encode($aprendieron_a_montar) !!};
			aprendieron_a_montar = aprendieron_a_montar.map(function(registro) {
				return {x: registro.x, y: +registro.y};
			});

			var ctx_aprendieron_a_montar = $('#aprendieron_a_montar');
			var chart_aprendieron_a_montar = new Chart(ctx_aprendieron_a_montar, {
				type: 'bar',
				data: {
					labels: aprendieron_a_montar.map(function(registro) {
						return registro.x;
					}),
					datasets: [{
						data: aprendieron_a_montar.map(function(registro) {
							return +registro.y;
						}), 
						backgroundColor: aprendieron_a_montar.map(function(registro) {
							return 'rgba(69, 39, 160, 0.5)';
						}),
						label: '# personas que han aprendido a montar en bicicleta.',
					}]
				},
				options: {
                    maintainAspectRatio: false,
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

			var hombres_y_mujeres = {!! json_encode($hombres_y_mujeres) !!};
			var ctx_aprendieron_a_montar = $('#hombres_y_mujeres');
			var chart_aprendieron_a_montar = new Chart(ctx_aprendieron_a_montar, {
				type: 'pie',
				data: {
					datasets: [{
						data: [hombres_y_mujeres.Hombres, hombres_y_mujeres.Mujeres],
						backgroundColor: [
							'rgba(40, 53, 147, 0.5)',
							'rgba(106, 27, 154, 0.5)'
						]
					}],
					labels: [
						'Hombres',
						'Mujeres'
					],
				},
				options: {
                    maintainAspectRatio: false
				}
			});


			var ciclo_biologico = {!! json_encode($ciclo_biologico) !!};
			ciclo_biologico = ciclo_biologico.map(function(registro) {
				return {x: registro.x, y: +registro.y};
			});
			var ctx_ciclo_biologico = $('#ciclo_biologico');
			var chart_ciclo_biologico = new Chart(ctx_ciclo_biologico, {
				type: 'bar',
				data: {
					labels: ciclo_biologico.map(function(registro) {
						return registro.x;
					}),
					datasets: [{
						data: ciclo_biologico.map(function(registro) {
							return +registro.y;
						}), 
						backgroundColor: ciclo_biologico.map(function(registro) {
							return 'rgba(69, 39, 160, 0.5)';
						}),
						label: '# personas atendidas por ciclo biológico.',
					}]
				},
				options: {
                    maintainAspectRatio: false,
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

			$('#consultar').on('click', function(e) {
				$.post('{{ url("panel/consulta") }}', {
					fecha_inicio: $('input[name="fecha_inicio"]').val(),
					fecha_fin: $('input[name="fecha_fin"]').val()
				}).done(function(data) {
					console.log(data);

					$('#cantidad_procesos_rango').html('<span><strong>'+data.procesos.total+'</strong> procesos realizados.</span>');
					
					var opciones = '';
					data.indicadores_de_aprendizaje.map(function(e) {
						opciones += '<span>'+e.avance+' <strong>'+e.total+'</strong></span><br>';
					});
					$('#indicadores_aprendizage_rango').html(opciones);

					$('#hombres_mujeres_atendidas_rango').html('<span><strong>'+data.hombres_y_mujeres.Hombres+'</strong> hombres</span><br><span><strong>'+data.hombres_y_mujeres.Mujeres+'</strong> mujeres</span>');

					var actividades = '';
					data.tipos_de_actividades.map(function(e) {
						actividades += '<span>'+e.Tipo+' <strong>'+e.total+'</strong></span><br>';
					});
					$('#tipo_actividad_rango').html(actividades);
				})
			});
		})
	</script>
@stop

@section('content') 
	<div class="content">
		<div id="main" class="row">
			<div class="col-md-12">
				<h4>Datos generales</h4>
			</div>
			<div class="col-md-12">
				<br>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4" style="position: relative; height: 400px;">
						<canvas id="procesos_anio"></canvas>
					</div>
					<div class="col-md-4" style="position: relative; height: 400px;">
						<canvas id="aprendieron_a_montar"></canvas>
					</div>
					<div class="col-md-4" style="position: relative; height: 400px;">
						<canvas id="hombres_y_mujeres"></canvas>
					</div>
					<div class="col-md-8" style="position: relative; height: 400px;">
						<canvas id="ciclo_biologico"></canvas>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<br>
			</div>
			<div class="col-md-12">
				<h4>Mas información</h4>
			</div>
			<div class="col-md-12">
				<br>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-2 form-group">
                        <label for="">Desde</label>
                        <input name="fecha_inicio" type="text" placeholder="Desde" class="form-control" data-role="datepicker" data-rel="fecha_inicio" data-fecha-inicio="" data-fecha-fin="" data-fechas-importantes="{{-- Festivos::create()->datesToString() --}}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="">Hasta</label>
                        <input name="fecha_fin" type="text" placeholder="Hasta" class="form-control" data-role="datepicker" data-rel="fecha_fin" data-fecha-inicio="" data-fecha-fin="" data-fechas-importantes="{{-- Festivos::create()->datesToString() --}}">
                    </div>
					<div class="col-md-2 form-group">
                        <label for="">&nbsp;</label><br>
                        <button type="button" id="consultar" class="btn btn-success">Consultar</button>
                    </div>
                </div>
			</div>
			<div class="col-md-12">
				<br>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<strong>Resumen de los indicadores de aprendizaje</strong><br><br>
						<div id="indicadores_aprendizage_rango">--</div>
					</div>
					<div class="col-md-12">
						<br>
						<strong>Cantidad de procesos realizados</strong><br><br>
						<div id="cantidad_procesos_rango">--</div>
					</div>
					<div class="col-md-12">
						<br>
						<strong>Hombres, mujeres y total de personas atendidas</strong><br><br>
						<div id="hombres_mujeres_atendidas_rango">--</div>
					</div>
					<div class="col-md-12">
						<br>
						<strong>Tipo de actividad</strong><br><br>
						<div id="tipo_actividad_rango">--</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<br><br>
			</div>
		</div>
	</div>
@stop
