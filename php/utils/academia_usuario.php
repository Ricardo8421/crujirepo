<?php
//action="FormularioDatosEnvio.php"
session_start();
header('Content-type: application/json; charset=UTF-8');
#$id = session_id();

include "conexion.php";
$result = $mysql->query("SELECT departamento FROM profesor where id='".$_SESSION["usuario"]."'");

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $departamento = $row["departamento"];     
    }
    printf($departamento);
    $resultado=[];
    $i=0;
    $result = $mysql->query("SELECT nombre FROM academia where departamento='$departamento'");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $academia = $row["nombre"];     
            #echo(json_encode( $academia));
            $resultado[$i]=$academia;
            $i++;
        }
        echo(json_encode($resultado));
    
    }

}

?>