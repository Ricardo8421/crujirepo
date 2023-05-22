<?php
// session_Start();
// if(!isset($_SESSION["usu"]) || !isset($_SESSION["con"])){
// 	header("Location: /asterocritico");
// }

include "conexion.php";
session_Start();
$redb = false;
$red = "";
if(!isset($_SESSION["usu"]) || !isset($_SESSION["con"])){
	$redb = true;
  	session_destroy();
}else{
  	$p = sprintf("SELECT permiso, accesoCongelado FROM usuario LEFT OUTER JOIN profesor ON usuario.id=profesor.idUsuario WHERE login='%s' AND pass='%s'",
    	$xd->real_escape_string($_SESSION["usu"]),
    	$xd->real_escape_string($_SESSION["con"]));
	$r = $xd->query($p);
	if($r->num_rows > 0){
		while($f = $r->fetch_assoc()){
      		if($f["permiso"]==1){
        		$redb = true;
				$red = "/formulario.php";
			}
		}
	}else{
    	session_destroy();
    	$redb = true;
	}
}

if($redb){
  	header("Location: /asterocritico".$red);
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/a0a5eb5331.js" crossorigin="anonymous"></script>
</head>

<body class="bg-lighter-escom">

	<nav class="navbar bg-dark-escom">
		<div class="container-fluid">
			<a class="navbar-brand text-light">Sistema de profesores</a>
			<form action="/asterocritico/" class="d-flex" method="post">
				<input type="hidden" value="cerrarsesion" name="cs">
				<button class="btn btn-success" type="submit">Cerrar sesión</button>
			</form>
		</div>
	</nav>

	<div class="modal fade" id="resetConfirmationModal" tabindex="-1" aria-labelledby="resetConfirmationLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="resetConfirmationLabel">Confirmación</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>¿Seguro que quieres resetear el registro de este profesor?</p>
					<small class="text-danger">Esta acción no se puede deshacer</small>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-danger">Eliminar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="checkDataModal" tabindex="-1" aria-labelledby="checkDataLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="checkDataLabel">Datos</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form>
					<div class="modal-body">
						<fieldset>
							<legend>Datos del profesor</legend>
							<div class="mb-3">
								<label for="teacherIdInput" class="form-label">Identificador</label>
								<input disabled type="text" id="teacherIdInput" class="form-control" value="2000121234">
							</div>
							<div class="mb-3">
								<label for="teacherNameInput" class="form-label">Nombre</label>
								<input type="text" class="form-control" id="teacherNameInput"
									value="<Nombre del profe>">
							</div>
							<div class="mb-3">
								<label for="teacherEmailInput" class="form-label">Correo</label>
								<input type="email" class="form-control" id="teacherEmailInput"
									value="emailDelProfe@idk.com">
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
								<label class="form-check-label" for="flexCheckChecked">
									Acceso permitido
								</label>
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-success">Guardar Cambios</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="container pt-3">
		<div class="row">
			<div class="col-7"></div>
			<div class="col justify-content-end d-flex">
				<button class="btn btn-success" type="button" id="addTeacher" data-bs-toggle="modal"
				data-bs-target="#checkDataModal"><i class="fa-solid fa-plus"></i> Agregar profesor</button>
				<button class="btn btn-primary" type="button" id="filter" data-bs-toggle="modal"
				data-bs-target="#filterPopup"><i class="fa-solid fa-sliders"></i> Filtrar</button>
			</div>
		</div>
		<div class="row mt-3"></div>

		<div class="row d-none d-md-flex">
			<div class="col bg-escom text-light text-center">
				<h3>Profesor</h3>
			</div>
			<div class="col bg-escom text-light text-center">
				<h3>Datos</h3>
			</div>
			<div class="col bg-escom text-light text-center">
				<h3>PDF</h3>
			</div>
			<div class="col bg-escom text-light text-center">
				<h3>Resetear</h3>
			</div>
		</div>

		<!-- 
			Esto se va generando según los usuarios que han respondido
			Los que van cambiando son los que tienen un comentario antes
		 -->
		<div class="row">
			<div class="col-12 col-sm-6 d-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Profesor</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- Este va cambiando -->
				<h6>Juanito Perez Lopez</h6>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Datos</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<button class="btn btn-primary" type="button" id="checkData0" data-bs-toggle="modal"
					data-bs-target="#checkDataModal"><i class="fa-solid fa-eye"></i> Revisar
					datos</button>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>PDF</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- La id / la acción va cambiando -->
				<button id="pdf-0" class="btn btn-warning" type="button"><i class="fa-solid fa-download"></i> Descargar
					PDF</button>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Resetear</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- La id / la acción va cambiando -->
				<button id="reset0" class="btn btn-danger" type="button" data-bs-toggle="modal"
					data-bs-target="#resetConfirmationModal"><i class="fa-solid fa-trash"></i> Resetear
					formulario</button>
			</div>
		</div>
		<div class="row d-flex d-md-none mt-3"></div>
		<!-- Aquí termina la generación -->

		<!-- 
			Esto se va generando según los usuarios que han respondido
			Los que van cambiando son los que tienen un comentario antes
		 -->
		 <div class="row">
			<div class="col-12 col-sm-6 d-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Profesor</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- Este va cambiando -->
				<h6>Miguel Sanchez</h6>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Datos</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<button class="btn btn-primary" type="button" id="checkData0" data-bs-toggle="modal"
					data-bs-target="#checkDataModal"><i class="fa-solid fa-eye"></i> Revisar
					datos</button>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>PDF</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- La id / la acción va cambiando -->
				<button id="pdf-0" class="btn btn-warning" type="button"><i class="fa-solid fa-download"></i> Descargar
					PDF</button>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Resetear</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- La id / la acción va cambiando -->
				<button id="reset0" class="btn btn-danger" type="button" data-bs-toggle="modal"
					data-bs-target="#resetConfirmationModal"><i class="fa-solid fa-trash"></i> Resetear
					formulario</button>
			</div>
		</div>
		<div class="row d-flex d-md-none mt-3"></div>
		<!-- Aquí termina la generación -->

		<!-- 
			Esto se va generando según los usuarios que no han respondido
			Los que van cambiando son los que tienen un comentario antes
		 -->
		<div class="row">
			<div class="col-12 col-sm-6 d-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Profesor</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- Este va cambiando -->
				<h6>Maria Morales</h6>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Datos</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- Este va cambiando -->
				<h6>madartes@gmail.com</h6>
			</div>
			<div class="col-12 col-md-6 d-flex bg-escom text-light text-center pt-2 pb-2">
				<h6>Este usuario no ha contestado su encuesta</h6>
			</div>
		</div>
		<div class="row d-flex d-md-none mt-3"></div>
		<!-- Aquí termina la generación -->

		<!-- 
			Esto se va generando según los usuarios que no han respondido
			Los que van cambiando son los que tienen un comentario antes
		 -->
		<div class="row">
			<div class="col-12 col-sm-6 d-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Profesor</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- Este va cambiando -->
				<h6>Brayan Hernandedz</h6>
			</div>
			<div class="col-12 col-sm-6 d-none d-sm-flex d-md-none bg-escom text-light text-center pt-2 pb-2">
				<h6>Datos</h6>
			</div>
			<div class="col-12 col-sm-6 col-md-3 bg-light-escom text-center pt-2 pb-2">
				<!-- Este va cambiando -->
				<h6>hernandedz@gmail.com</h6>
			</div>
			<div class="col-12 col-md-6 d-flex bg-escom text-light text-center pt-2 pb-2">
				<h6>Este usuario no ha contestado su encuesta</h6>
			</div>
		</div>
		<div class="row d-flex d-md-none mt-3"></div>
		<!-- Aquí termina la generación -->

	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
		integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
		integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
		crossorigin="anonymous"></script>
</body>

</html>