<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

//Problemas
$b = false;

if(isset($_POST["clave"])){
    $clave = $_POST["clave"];
    $query = sprintf("DELETE FROM materia WHERE clave='%s'",
        $mysql->real_escape_string($clave));
    $mysql->query($query);
    if($mysql->affected_rows > 0){
        $r["resultado"] = "Eliminación completa";
        $b=true;
    }
}

if(!$b){
    $r["resultado"] = "Algo salió mal";
}

$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;

?>