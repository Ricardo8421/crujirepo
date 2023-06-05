<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;
$idUsuario = "9f094c750c";
$nombre = "pedrololango";
$departamento = "ASFD";
$acceso = "1";

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_POST["acceso"]) && isset($_POST["id"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $acceso = $_POST["acceso"];
    $query = "SELECT clave FROM departamento";
    $d = $mysql->query($query);
    if($d->num_rows>0 && !empty($idUsuario) && !empty($nombre) && ($acceso == 1 || $acceso == 0)){
        while($f = $d->fetch_assoc()){
            if($f["clave"]==$departamento){
                // Ejecutar query
                break;
            }
        }
    }
}
    
if(!$b){
    $r["resultado"] = "Algo salió mal";
}else{
    $r["resultado"] = "chido";
}
 
$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;
?>