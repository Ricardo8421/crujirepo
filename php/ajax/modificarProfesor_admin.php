<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_POST["acceso"]) && isset($_POST["id"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $acceso = $_POST["acceso"];
    $idProfesor = $_POST["id"];
    $query = sprintf("SELECT clave FROM departamento WHERE clave='%s'",
        $mysql->real_escape_string($departamento));
    $d = $mysql->query($query);
    if($d->num_rows>0 && !empty($idProfesor) && !empty($nombre) && ($acceso == 1 || $acceso == 0)){
        $query = sprintf("UPDATE profesor SET nombreCompleto='%s', departamento='%s', accesoCongelado='%s' WHERE idUsuario=%d",
            $mysql->real_escape_string($nombre),
            $mysql->real_escape_string($departamento),
            $mysql->real_escape_string($acceso),
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
 
$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;
?>