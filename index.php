<?php
include 'conexion.php';

session_start();
$isLoggingIn = isset($_POST["usuario"]) && isset($_POST["contra"]);
$alreadyLoggedIn = isset($_SESSION["usuario"]) && isset($_SESSION["contra"]);
$shouldRedirect = false;

if (isset($_POST["cerrarSesion"])) {
	session_destroy();
} elseif ($isLoggingIn || $alreadyLoggedIn) {

	if ($isLoggingIn) {
		$username = $_POST["usuario"];
		$password = $_POST["contra"];
	} else {
		$username = $_SESSION["usuario"];
		$password = $_SESSION["contra"];
	}

	$query = sprintf(
		"SELECT permiso, accesoCongelado FROM usuario LEFT OUTER JOIN profesor ON usuario.id=profesor.idUsuario WHERE login='%s' AND pass='%s'",
		$mysql->real_escape_string($username),
		$mysql->real_escape_string($password)
	);
	$result = $mysql->query($query);

	// echo $p;
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			$shouldRedirect = true;
			if ($isLoggingIn) {
				$_SESSION["usuario"] = $username;
				$_SESSION["contra"] = $password;
			}
			if ($row["permiso"] == 2) {
				$red = "profesores.php";
				// echo "adm";
			} else {
				$red = "formulario.php";
				// echo "pofe";
			}
		}
	}
}

if ($shouldRedirect) {
	header("Location: ./" . $red);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio de sesión</title>
	<link rel="stylesheet" href="css/colors.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body class="bg-gradient-escom">

	<div class="container-fluid vh-100">
		<div class="row align-items-center justify-content-center h-100">
			<div class="col-md-5 col-sm-8 col-11 rounded-5 bg-light-escom align-items-center">
				<div class="row align-items-center h-100">
					<div class="col p-5">
						<h3>Sistema profesores</h3>
						<form class="col-12" method="post">
							<div class="mb-3">
								<label for="username_input" class="form-label">Identificador</label>
								<input type="text" class="form-control" id="username_input" name="usuario">
							</div>
							<div class="mb-3">
								<label for="password_input" class="form-label">Contraseña</label>
								<input type="password" class="form-control" id="password_input" name="contra">
							</div>
							<div class="mb-3">
								<?php
								if (isset($_POST["usuario"]) || isset($_POST["contra"])) {
									?>
									<p class="text-danger">Datos incorrectos</p>
									<?php
								} else {
									?>
									<p class="text-secondary">Al entrar a este sitio acepta el uso de cookies</p>
								<?php
								}
								?>
							</div>
							<button type="submit" class="btn btn-primary">Ingresar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
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