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
	<link rel="icon" href="./assets/Escom.png" type="image/x-icon" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a0a5eb5331.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-lighter-escom">

	<nav class="navbar bg-dark-escom">
		<div class="container-fluid">
		<button class="btn btn-success" id="volver" type="button">Regresar</button>
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
				<button class="btn btn-warning btn-download" data-bs-toogle="modal"  date-bs-target="#crudModal"><i class="fa-regular fa-file-pdf"></i>Zona de descargas</button>
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
							<thead>
								<tr>
									<th class="text-center align-middle bg-dark-escom text-light">MATERIA</th>
									<th class="text-center align-middle bg-dark-escom text-light">ACADEMIA</th>
									<th class="text-center align-middle bg-dark-escom text-light">SEMESTRE</th>
									<th class="text-center align-middle bg-dark-escom text-light">PLAN</th>
									<th class="text-center align-middle bg-dark-escom text-light">CARRERA</th>
									<th class="text-center align-middle bg-dark-escom text-light">EDITAR</th>
									<th class="text-center align-middle bg-dark-escom text-light">BORRAR</th>
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

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous"></script>
	<script src="js/crud/materiasAjax.js"></script>
	<script src="js/crud/modalForm.js"></script>
	<script src="js/downloadAcademy.js" ></script>
	<script src="js/botones_redireccion.js"></script>
</body>

</html>
