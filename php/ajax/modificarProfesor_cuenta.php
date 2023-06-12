<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;

if(isset($_SESSION["usuario"]) && isset($_POST["contrasena"]) && isset($_POST["usuario"])){
    $usuarioAntiguo = $_POST["usuario"];
    $usuarioViejo = $_SESSION["usuario"];
    $contra = $_POST["contra"];
    $query = sprintf("SELECT id FROM usuario WHERE `login`='%s' AND pass='%s'",
        $mysql->real_escape_string($usuarioViejo),
        $mysql->real_escape_string($contra));
    $u = $mysql->query($query);
    if($u->num_rows > 0){
        $f=$u->fetch_assoc();
        $query = sprintf("UPDATE usuario SET `login`='%s' WHERE id=%d",
            $mysql->real_escape_string($usuarioAntiguo),
            $mysql->real_escape_string($f["id"]));
        $mysql->query($query);
        if($mysql->affected_rows > 0){
            $r["msg"]="Sí jaló paps";
            $b=true;
        }
    }
}
    
if(!$b){
    $r["msg"] = "Algo salió mal";
}

$r["success"] = $b;

$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;
?>