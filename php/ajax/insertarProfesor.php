<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');
$b=false;

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_POST["contrasena"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $contra = $_POST["contrasena"];
    $query = "SELECT clave FROM departamento";
    $d = $mysql->query($query);    
    if($d->num_rows>0 && !empty($nombre) && !empty($contra)){
        while($f = $d->fetch_assoc()){
            if($f["clave"]==$departamento){
                $query = sprintf("CALL createProfesor('%s', '%s', '%s')",
                    $mysql->real_escape_string($nombre),
                    $mysql->real_escape_string($departamento),
                    $mysql->real_escape_string($contra)
                );
                if($mysql->query($query)){
                    $r["resultado"] = "Registro correcto";
                    $b = true;
                }
                break;
            }
        }
    }
    
}
    
if(!$b){
    $r["resultado"] = "Algo salió mal";
}
$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;


?>