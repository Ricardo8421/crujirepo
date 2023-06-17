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
    <link rel="icon" href="./assets/Escom.png" type="image/x-icon" />
    <title>Página con Botones</title>
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/loadingRing.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/formulario_styles.css">
    <link rel="stylesheet" href="css/botones.css">
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

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12 text-center carta">
                <h3>Seleccione qué desea administrar</h3>
                <div class="my-4">
                    <button class="btn btn btn-primary btn-lg btn-large" id="profesores";>
                        Profesores
                    </button>
                </div>
                <div class="my-4">
                    <button class="btn btn-secondary btn-lg btn-large" id="materias">
                        Materias
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
        <script src="js/botones_redireccion.js"></script>

</body>

</html>
