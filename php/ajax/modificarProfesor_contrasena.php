<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');
session_start();

$b=false;

if(isset($_SESSION["usuario"]) && isset($_POST["contrasenaConfirmacion"]) && isset($_POST["contrasenaAntigua"]) && isset($_POST["contrasenaNueva"])){
    $usuario = $_SESSION["usuario"];
    $contraVieja = $_POST["contrasenaAntigua"];
    $contraAntigua = $_POST["contrasenaNueva"];
    $confirmacion = $_POST["contrasenaConfirmacion"];
    if($confirmacion==$contraAntigua){
        $query = sprintf("SELECT id FROM usuario WHERE `login`='%s' AND pass='%s'",
            $mysql->real_escape_string($usuario),
            $mysql->real_escape_string($contraVieja));
        $d = $mysql->query($query);
        if($d->num_rows > 0){
            $f=$d->fetch_assoc();
            $query=sprintf("UPDATE usuario SET pass='%s' WHERE id=%d",
                $mysql->real_escape_string($contraAntigua),
                $mysql->real_escape_string($f["id"]));
            $mysql->query($query);
            if($mysql->affected_rows > 0){
                $r["msg"]="Sí jaló paps";
                $b=true;
            }
        }
    }
}
    
if(!$b){
    $r["msg"] = "Algo salió mal";
}

$r["success"]=$b;

$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;
?>