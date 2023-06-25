<?php
require "php/utils/login.php";
session_start();

$redirect = checkSession(1);

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
	<link rel="icon" href="./assets/Escom.png" type="image/x-icon" />
	<link rel="stylesheet" href="css/colors.css">
	<link rel="stylesheet" href="css/loadingRing.css">
	<link rel="stylesheet" href="css/teacherCard.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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

	<div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editTeacherLabel">
						Editando datos personales
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="teacherForm">
					<div class="modal-body">
						<fieldset>
							<div id="teacherAlert"></div>
							<div class="mb-3">
								<label for="inputMatricula" class="form-label">Matrícula</label>
								<input readonly type="text" id="inputMatricula" class="form-control" name="matricula">
							</div>
							<div class="mb-3">
								<label for="inputNombre" class="form-label">Matrícula</label>
								<input required type="text" id="inputNombre" class="form-control" name="nombre">
							</div>
							<div class="mb-3">
								<div class="form-group">
									<label for="inputDepartamento" class="form-label">Departamento</label>
									<div id="dropdownDepartamento" class="input-group">
										<select required id="inputDepartamento" class="form-control chosen-select"
											style="width:350px;" name="departamento"></select>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-success" id="teacherSubmitButton">Guardar Cambios</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editUserLabel">
						Editando datos personales
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="userForm">
					<div class="modal-body">
						<fieldset>
							<div id="userAlert"></div>
							<div class="mb-3">
								<label for="inputPrevPass" class="form-label">Contraseña actual</label>
								<input required type="password" id="inputPrevPass" class="form-control"
									name="contrasenaAntigua" placeholder="Contraseña actual">
							</div>
							<div class="mb-3">
								<label for="inputNewPass" class="form-label">Nueva contraseña</label>
								<input required type="password" id="inputNewPass" class="form-control"
									name="contrasenaNueva" placeholder="Nueva contraseña">
							</div>
							<div class="mb-3">
								<label for="inputConfirmationPass" class="form-label">Confirmar contraseña</label>
								<input required type="password" id="inputConfirmationPass" class="form-control"
									name="contrasenaConfirmacion" placeholder="Confirme su contraseña">
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-success" id="userSubmitButton">Guardar Cambios</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="container my-4">
		<div class="row d-flex justify-content-center">
			<div class="col-md-7">
				<div class="card p-3 py-4" id="generatedContainer">
					<div class="text-center align-middle">
						<div class="lds-dual-ring"></div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous"></script>
	<script src="js/escapeHtml.js"></script>
	<script src="js/crud/profesorAjax.js"></script>
</body>

</html>