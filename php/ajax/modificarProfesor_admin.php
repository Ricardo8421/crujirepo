<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_POST["accesoCongelado"]) && isset($_POST["idUsuario"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $acceso = $_POST["accesoCongelado"];
    $idProfesor = $_POST["idUsuario"];
    $query = sprintf("SELECT clave FROM departamento WHERE clave='%s'",
        $mysql->real_escape_string($departamento));
    $d = $mysql->query($query);
    if($d->num_rows>0 && !empty($idProfesor) && !empty($nombre) && ($acceso == 'true' || $acceso == 'on')){
        $query = sprintf("UPDATE profesor SET nombreCompleto='%s', departamento='%s', accesoCongelado='%s' WHERE idUsuario=%d",
            $mysql->real_escape_string($nombre),
            $mysql->real_escape_string($departamento),
            ($mysql->real_escape_string($acceso)=='on')?1:0,
            $mysql->real_escape_string($idProfesor)
        );
        $mysql->query($query);
        if($mysql->affected_rows > 0){
            $r["resultado"] = "Modificación exitosa";
            $b=true;
        }
    }
}
    
if(!$b){
    $r["resultado"] = "Algo salió mal";
}
$r["success"] = $b;
 
$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;
?>