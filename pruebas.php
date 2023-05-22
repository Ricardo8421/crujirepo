<?php
include "conexion.php";
$u = "bd5dff0b5a";
$c = "jt";

$p = sprintf("SELECT permiso, accesoCongelado FROM usuario LEFT OUTER JOIN profesor ON usuario.id=profesor.idUsuario WHERE login='%s' AND pass='%s'",
    $xd->real_escape_string($u),
    $xd->real_escape_string($c));
$r = $xd->query($p);
   
// echo $p;
if($r->num_rows > 0){
    while($f = $r->fetch_assoc()){
        $redb = true;
        if($bandera){
            $_SESSION["usu"]=$u;
            $_SESSION["con"]=$c;
        }
        if($f["permiso"]==2){
            $red = "profesores.php";
            echo "adm";
        }else{
            $red = "formulario.php";
            echo "pofe";
        }
    }
}else{
    echo "aqui";
}


?>