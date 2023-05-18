<?php
include 'conexion.php';

session_start();
$inicio = isset($_POST["usuario"]) && isset($_POST["contra"]);
$se = isset($_SESSION["usu"]) && isset($_SESSION["con"]);
$redb = false;
if(isset($_POST["cs"])){
	session_destroy();
}elseif($inicio || $se){
	if($inicio){
		$u = $_POST["usuario"];
		$c = $_POST["contra"];
		$bandera=true;
	}else{
		$u=$_SESSION["usu"];
		$c=$_SESSION["con"];
		$bandera=false;
	}

	$p = sprintf("SELECT permiso, accesoCongelado FROM usuario LEFT OUTER JOIN profesor ON usuario.id=profesor.idUsuario WHERE login='%s' AND pass='%s'",
    	$con->real_escape_string($u),
    	$con->real_escape_string($c));
	$r = $con->query($p);
	
	// echo $p;
	if($r->num_rows > 0){
		while($f = $r->fetch_assoc()){
			$redb = true;
			if($bandera){
				$_SESSION["usu"]=$u;
				$_SESSION["con"]=$c;
			}
			if($f["permiso"]==2){
				$red = "profesores.php";
				echo "adm";
			}else{
				$red = "formulario.php";
				echo "pofe";
			}
		}
	}else{
		echo "aqui";
	}
}
if($redb){
	header("Location: /asterocritico/".$red);
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
								if(isset($_POST["usuario"]) || isset($_POST["contra"])){
								?>
									<p class="text-danger">Datos incorrectos</p>
								<?php
								}else{
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