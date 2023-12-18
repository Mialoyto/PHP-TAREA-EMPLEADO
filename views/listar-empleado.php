<!doctype html>
<html lang="es">

<head>
	<title>Tabla empleados</title>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!-- Bootstrap CSS v5.2.1 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
	<div class="container-fluid" style="max-width:100rem;">
		<div class="card mt-2">
			<div class="card-header bg-secondary text-light">BUSCAR EMPLEADOS</div>
			<div class="card-body">
				<form action="">

					<a href="registra-empleado.php"><button type="button" class="btn btn-success btn-block mb-3">REGISTRAR</button></a>
					<a href="buscador-empleado.php"><button type="button" class="btn btn-primary btn-block mb-3">BUSCAR</button></a>

					<div class="form-control mb-3 table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>SEDE</th>
									<th>APELLIDOS</th>
									<th>NOMBRES</th>
									<th>NÚMERO DOCUMENTO</th>
									<th>FECHA NACIMIENTO</th>
									<th>TELEFONO</th>
								</tr>
							</thead>
							<tbody class="table-striped" id="tabla">


							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		document.addEventListener("DOMContentLoaded", () => {
			function $(id) {
				return document.querySelector(id)
			}

			(function() {

				const tabla = $("tabla");

				fetch(`../controllers/empleado.controller.php?operacion=listar`)
					.then(respuesta => respuesta.json())
					.then(datos => {
						console.log(datos);

						const tabla = $("#tabla")

						datos.forEach(datos => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${datos.sede}</td>
                            <td>${datos.apellidos}</td>
                            <td>${datos.nombres}</td>
                            <td>${datos.nrodoc}</td>
                            <td>${datos.fechanac}</td>
                            <td>${datos.telefono}</td>
                        `
                        tabla.appendChild(row);
                    });

					})
					.catch(e => {
						console.error(e)
					})
			})();



		})
	</script>
</body>

</html>