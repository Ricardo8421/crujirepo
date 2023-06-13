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
	<title>Administración de materias</title>
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

	<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="crudModalLabel"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="crudForm">
					<div class="modal-body">
						<fieldset id="generatedForm">
						</fieldset>
						<small class="text-danger" id="crudMsg"></small>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-success" id="crudSubmitButton">Guardar Cambios</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="container-fluid pt-3">
		<div class="row">
			<div class="col-7" id="errorsongos"></div>
			<div class="col justify-content-end d-flex">
				<button class="btn btn-success btn-create" data-bs-toggle="modal" data-bs-target="#crudModal"><i class="fa-solid fa-plus"></i> Agregar Materia</button>
				<button class="btn btn-primary btn-read" data-bs-toggle="modal" data-bs-target="#crudModal"><i class="fa-solid fa-sliders"></i> Filtrar</button>
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