<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');
$b=false;

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_POST["matricula"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $contra = $_POST["matricula"];
    $query = sprintf("SELECT clave FROM departamento WHERE clave='%s'",
        $mysql->real_escape_string($departamento));
    $d = $mysql->query($query);
    if($d->num_rows>0 && !empty($nombre) && !empty($contra)){
        $query = sprintf("CALL createProfesor('%s', '%s', '%s')",
            $mysql->real_escape_string($contra),
            $mysql->real_escape_string($nombre),
            $mysql->real_escape_string($departamento)
        );
        $est = $mysql->query($query);
        if(!isset($est->num_rows)){
            $r["resultado"] = "Registro correcto";
            $b = true;
        }
    }
}
    
if(!$b){
    $r["resultado"] = "Algo salió mal";
}
$r["success"]=$b;
$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;


?>