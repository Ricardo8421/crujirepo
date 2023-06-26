<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=true;

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_POST["accesoCongelado"]) && isset($_POST["idUsuario"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $acceso = $_POST["accesoCongelado"];
    $idProfesor = $_POST["idUsuario"];
    $query = sprintf("SELECT clave FROM departamento WHERE clave='%s'",
        $mysql->real_escape_string($departamento));
    $d = $mysql->query($query);

	if ($d->num_rows<=0) {
		$b = false;
		$r["resultado"] = "El departamento no existe";
	}

	if (empty($idProfesor)) {
		$b = false;
		$r["resultado"] = "El id del profesor no puede estar vacio";
	}

	if (empty($nombre)) {
		$b = false;
		$r["resultado"] = "El nombre del profesor no puede estar vacio";
	}

	if ($acceso != 'true' && $acceso != 'on') {
		$b = false;
		$r["resultado"] = $acceso;
	}

    if($b){
        $query = sprintf("UPDATE profesor SET nombreCompleto='%s', departamento='%s', accesoCongelado='%s' WHERE idUsuario=%d",
            $mysql->real_escape_string($nombre),
            $mysql->real_escape_string($departamento),
            ($mysql->real_escape_string($acceso)=='on')?1:0,
            $mysql->real_escape_string($idProfesor)
        );
        $mysql->query($query);
        if($mysql->affected_rows > 0){
            $r["resultado"] = "Modificación exitosa";
        } else {
            $b=false;
			$r["resultado"] = "Hubo un error al conectarse a la base de datos, inténtelo más tarde";
		}
    }
} else {
	$r["resultado"] = "Campos vacios";
}

$r["success"] = $b;
 
$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;
