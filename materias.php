<?php
require "php/utils/login.php";
session_start();

$redirect = checkSession(2);

if (!is_null($redirect)) {
	header("Location: ./" . $redirect);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administración de profesores</title>
	<link rel="stylesheet" href="css/colors.css">
	<link rel="stylesheet" href="css/loadingRing.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a0a5eb5331.js" crossorigin="anonymous"></script>
</head>

<body class="bg-lighter-escom">

	<nav class="navbar bg-dark-escom">
		<div class="container-fluid">
			<a class="navbar-brand text-light">Sistema de profesores</a>
			<form action="logout" class="d-flex">
				<button class="btn btn-success" type="submit">Cerrar sesión</button>
			</form>
		</div>
	</nav>

	<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteConfirmationLabel">Confirmación</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form>
					<div class="modal-body">
						<input type="hidden" id="deleteConfirmationInput">
						<p>¿Seguro que quieres elminiar esta materia del sistema?</p>
						<small class="text-danger">Esta acción no se puede deshacer</small>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" id="deleteConfirmationButton">Eliminar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editDataLabel">Editando los datos de la materia</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form>
					<div class="modal-body">
						<fieldset>
							<div class="mb-3">
								<label for="inputClaveMateria" class="form-label">Clave</label>
								<input disabled type="text" id="inputClaveMateria" class="form-control" placeholder="Clave de la materia" name="clave">
							</div>
							<div class="mb-3">
								<div class="form-group">
									<label for="inputAcademiaMateria" class="form-label">Academia</label>
									<div id="dropdownAcademiaMateria" class="input-group">
										<select id="inputAcademiaMateria" class="form-control chosen-select" style="width:350px;" name="academia">
											<option value="" selected disabled> Seleccione la academia </option>
											<?php
											$result = $mysql->query("SELECT id, nombre FROM academia");
											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo "<option value=\"" . $row["id"] . "\">" .  $row["nombre"] . "</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="mb-3">
								<label for="inputNombreMateria" class="form-label">Nombre</label>
								<input type="text" id="inputNombreMateria" class="form-control" placeholder="Nombre de la materia" name="nombre">
							</div>
							<div class="mb-3">
								<label for="inputSemestreMateria" class="form-label">Semestre</label>
								<input type="number" min="1" max=8" id="inputSemestreMateria" class="form-control" placeholder="Semestre de la materia" name="semestre">
							</div>
							<div class="mb-3">
								<label for="inputPlanMateria" class="form-label">Plan</label>
								<input type="number" min="2009" max="2040" id="inputPlanMateria" class="form-control" placeholder="Año de plan academico" name="plan">
							</div>
							<div class="mb-3">
								<div class="form-group">
									<label for="inputCarreraMateria" class="form-label">Carrera</label>
									<div id="dropdownCarreraMateria" class="input-group">
										<select id="inputCarreraMateria" name="carrera" class="form-control chosen-select" style="width:350px;">
											<option value="" selected disabled> Seleccione la Carrera </option>
											<option value="C">Academia bla</option>
											<option value="B">Ing. Inteligencia Artificial</option>
											<option value="A">Lic. Ciencia de Datos</option>
										</select>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-success" id="sumbitCrud">Guardar Cambios</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="container-fluid pt-3">
		<div class="row">
			<div class="col-7"></div>
			<div class="col justify-content-end d-flex">
			<button class="btn btn-success btn-create" type="button" id="addTeacher" data-bs-toggle="modal" data-bs-target="#editDataModal"><i class="fa-solid fa-plus"></i> Agregar Materia</button>
			<button class="btn btn-primary btn-read" type="button" id="filter" data-bs-toggle="modal" data-bs-target="#editDataModal"><i class="fa-solid fa-sliders"></i> Filtrar</button>
			</div>
		</div>
		<div class="row mt-3"></div>

		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card shadow-2-strong ">
					<div class="table-responsive">
						<table class="table table-borderless mb-0">
							<thead class="bg-dark-escom text-light">
								<tr>
									<th class="text-center align-middle">MATERIA</th>
									<th class="text-center align-middle">ACADEMIA</th>
									<th class="text-center align-middle">SEMESTRE</th>
									<th class="text-center align-middle">PLAN</th>
									<th class="text-center align-middle">CARRERA</th>
									<th class="text-center align-middle">EDITAR</th>
									<th class="text-center align-middle">BORRAR</th>
								</tr>
							</thead>
							<tbody id="generatedContainer">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

	<script src="js/crud/materiasAjax.js"></script>
	<script src="js/crud/modalForm.js"></script>
</body>

</html>