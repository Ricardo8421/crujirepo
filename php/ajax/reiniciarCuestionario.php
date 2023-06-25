<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;

if(isset($_POST["matricula"])){
    $matricula = $_POST["matricula"];
    $query = sprintf("DELETE FROM materiaRegistradas WHERE idProfesor='%s'",
        $mysql->real_escape_string($matricula));
    $mysql->query($query);
    $query = sprintf("DELETE FROM actividadRegistrada WHERE idProfesor=%d",
        $mysql->real_escape_string($matricula));
    $mysql->query($query);
    $query=sprintf("UPDATE profesor SET materiasExtra=NULL WHERE id='%s'",
        $mysql->real_escape_string($matricula));
    $mysql->query($query);
    if($mysql->affected_rows > 0){
        $r["resultado"]="Sí jaló paps";
        $b=true;
    }
}

if(!$b){
    $r["resultado"]="Algo salió mal";
}

$r["success"]=$b;

$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;
?>