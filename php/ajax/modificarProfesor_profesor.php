<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;

if(isset($_POST["nombre"]) && isset($_POST["departamento"]) && isset($_POST["contrasena"]) && isset($_SESSION["usuario"]) && isset($_POST["usuario"])){
    $nombre = $_POST["nombre"];
    $departamento = $_POST["departamento"];
    $usuarioViejo = $_POST["usuario"];
    $usuarioAntiguo = $_SESSION["usuario"];
    $contra = $_POST["contrasena"];
    $query = sprintf("SELECT clave FROM departamento WHERE clave='%s'",
        $mysql->real_escape_string($departamento));
    $d = $mysql->query($query);
    if($d->num_rows > 0 && !empty($nombre) && !empty($usuarioViejo) && !empty($usuarioAntiguo) && !empty($contra)){
        $query = sprintf("SELECT u.id, p.nombreCompleto, p.departamento, p.accesoCongelado FROM profesor p, usuario u WHERE p.idUsuario=u.id AND u.login='%s'",
            $mysql->real_escape_string($usuarioViejo)
        );
        $rs=$mysql->query($query);
        if($rs->num_rows > 0){
            $datosOriginales = $rs->fetch_assoc();
            $query = sprintf("UPDATE profesor SET nombreCompleto='%s', departamento='%s' WHERE idUsuario=%d",
                $mysql->real_escape_string($nombre),
                $mysql->real_escape_string($departamento),
                $mysql->real_escape_string($datosOriginales["id"])
            );
            $mysql->query($query);
            if($mysql->errno == 0){
                $query = sprintf("UPDATE usuario SET `login`='%s', pass='%s' WHERE id=%d",
                    $mysql->real_escape_string($usuarioAntiguo),
                    $mysql->real_escape_string($contra),
                    $mysql->real_escape_string($datosOriginales["id"])
                );
                $mysql->query($query);
                if($mysql->errno == 0){
                    $r["resultado"] = "Modificación exitosa";
                    $b=true;
                }else{
                    $query = sprintf("UPDATE profesor SET nombreCompleto='%s', departamento='%s', accesoCongelado='%s' WHERE idUsuario=%d",
                        $mysql->real_escape_string($datosOriginales["nombreCompleto"]),
                        $mysql->real_escape_string($datosOriginales["departamento"]),
                        $mysql->real_escape_string($datosOriginales["accesoCongelado"]),
                        $mysql->real_escape_string($datosOriginales["id"])
                    );
                    $mysql->query($query);
                }
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