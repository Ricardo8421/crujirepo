<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Registro concluído</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/a0a5eb5331.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/formulario_styles.css" />
	<link rel="stylesheet" href="css/colors.css" />
	<link rel="stylesheet" href="css/reset.css" />
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
	
	<main class="container flex flex--column flex--center">
	<h1 class="registry-header__title pt-3 pb-3">Registro Concluido</h1>
	<section class="registry-card carta">
		<span class="registry-card__icon-complete"></span>
		<h1 class="registry-card__title card__title">¡Registro completado!</h1>
		<a href="#" class="button btn btn-warning">Descargar PDF</a>
	</section>
	</main>
</body>

</html>