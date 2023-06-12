<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_SESSION["usuario"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $usuario = $_SESSION["usuario"];
    if(!empty($nombre)){
        $query = sprintf("SELECT d.clave, p.id FROM departamento d, usuario u, profesor p WHERE d.clave='%s' AND u.id=p.idUsuario AND u.login='%s'",
            $mysql->real_escape_string($departamento),
            $mysql->real_escape_string($usuario)
        );
        $d=$mysql->query($query);
        if($d->num_rows > 0){
            $f=$d->fetch_assoc();
            $query = sprintf("UPDATE profesor SET nombreCompleto='%s', departamento='%s' WHERE id='%s'",
                $mysql->real_escape_string($nombre),
                $mysql->real_escape_string($departamento),
                $mysql->real_escape_string($f["id"])
            );
            $mysql->query($query);
            if($mysql->affected_rows > 0){
                $r["msg"] = "Sí jaló paps";
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