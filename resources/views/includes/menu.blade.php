<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="{{ url('/welcome') }}" data-role="{{ $_SESSION ? implode($_SESSION['Usuario']['Roles']) : '' }}" class="navbar-brand">SIM</a>
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="navbar-collapse collapse" id="navbar-main">
			@if($_SESSION)
				<ul class="nav navbar-nav">
				@if (
					$_SESSION['Usuario']['Permisos']['administrar_promotores'] ||
					$_SESSION['Usuario']['Permisos']['administrar_escenarios'] ||
					$_SESSION['Usuario']['Permisos']['administrar_jornadas'] ||
					$_SESSION['Usuario']['Permisos']['administrar_reportes']
				)
					@if($_SESSION['Usuario']['Permisos']['administrar_promotores'])
						<li class="dropdown {{ $seccion && in_array($seccion, ['Promotores', 'Escenarios']) ? 'active' : '' }}">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Administración <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="{{ $seccion && $seccion == 'Promotores' ? 'active' : '' }}">
									<a href="{{ url('promotores') }}">Promotores</a>
								</li>
								<li class="{{ $seccion && $seccion == 'Escenarios' ? 'active' : '' }}">
									<a href="{{ url('escenarios') }}">Escenarios</a>
								</li>
								<li class="{{ $seccion && $seccion == 'Asignacion' ? 'active' : '' }}">
									<a href="{{ url('asignacion') }}">Asignar promotores escenarios</a>
								</li>
								<li class="{{ $seccion && $seccion == 'Programación promotores' ? 'active' : '' }}">
									<a href="{{ url('programacion_promotores') }}">Programación promotores</a>
								</li>
							</ul>
						</li>
					@endif
					@if($_SESSION['Usuario']['Permisos']['administrar_jornadas'])
						<li class="dropdown {{ $seccion && in_array($seccion, ['Buscar jornadas', 'Crear jornadas', 'Buscar actividades', 'Crear actividades']) ? 'active' : '' }}">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Promotor <span class="caret"></span></a>
							<ul class="dropdown-menu">
                                <li class="dropdown-header">
                                    Jornadas
                                </li>
								<li class="{{ $seccion && in_array($seccion, ['Asistencias']) ? 'active' : '' }}">
									<a href="{{ url('asistencias') }}">Asistencias</a>
								</li>
                                <li class="dropdown-header">
                                    Actividades institucionales
                                </li>
                                <li class="{{ $seccion && in_array($seccion, ['Buscar actividades']) ? 'active' : '' }}">
									<a href="{{ url('actividades') }}">Buscar</a>
								</li>
                                <li class="{{ $seccion && in_array($seccion, ['Crear actividades']) ? 'active' : '' }}">
									<a href="{{ url('actividades/formulario') }}">Crear</a>
								</li>
							</ul>
						</li>
					@endif
					@if($_SESSION['Usuario']['Permisos']['administrar_reportes'])
						<li class="dropdown {{ $seccion && in_array($seccion, ['Reporte general', 'Reporte consolidado', 'Reporte actividades']) ? 'active' : '' }}">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="{{ $seccion && in_array($seccion, ['Reporte general']) ? 'active' : '' }}">
									<a href="{{ url('reporte_asistencia') }}">General</a>
								</li>
                                <li class="{{ $seccion && in_array($seccion, ['Reporte actividades']) ? 'active' : '' }}">
									<a href="{{ url('reporte_actividades') }}">Actividades institucionales</a>
								</li>
								<li class="{{ $seccion && in_array($seccion, ['Reporte consolidado']) ? 'active' : '' }}">
									<a href="{{ url('reporte_consolidado') }}">Total asistencia</a>
								</li>
								<li class="{{ $seccion && in_array($seccion, ['Reporte general 2']) ? 'active' : '' }}">
									<a href="{{ url('reporte_general_2') }}">Reporte General</a>
								</li>
							</ul>
						</li>
					@endif
				@endif
				<li class="{{ $seccion && in_array($seccion, ['Certficado']) ? 'active' : '' }}">
					<a href="{{ url('certificado') }}">Certificado</a>
				</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="http://www.idrd.gov.co/sitio/idrd/" target="_blank">I.D.R.D</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						{{ $_SESSION['Usuario']['Persona']['Primer_Apellido'].' '.$_SESSION['Usuario']['Persona']['Primer_Nombre'] }}<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ url('logout') }}">Cerrar sesión</a>
							</li>
						</ul>
					</li>
				</ul>
			@endif
		</div>
	</div>
</div>