<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

//Problemas
$b = false;

if(isset($_POST["matricula"])){
    $matricula = $_POST["matricula"];
    $query = sprintf("SELECT idUsuario FROM profesor WHERE id='%s'",
        $mysql->real_escape_string($matricula));
    $res = $mysql->query($query);
    if($res->num_rows > 0){
        $f = $res->fetch_assoc();
        $query = sprintf("DELETE FROM usuario WHERE id='%s'",
            $mysql->real_escape_string($f["idUsuario"]));
        $mysql->query($query);
        if($mysql->affected_rows > 0){
            $r["resultado"] = "Eliminación completada";
            $b = true;
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