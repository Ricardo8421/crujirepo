<?php
//action="FormularioDatosEnvio.php"
session_start();
#$id = session_id();

include "conexion.php";

$result = $mysql->query("SELECT departamento FROM profesor where id='".$_SESSION["usuario"]."'");

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $departamento = $row["departamento"];     
    }
    printf($departamento);
    $result = $mysql->query("SELECT nombre FROM academia where departamento='$departamento'");
    if ($result->num_rows > 0) {
        $arregloAcademias=array();
        while ($row = $result->fetch_assoc()) {
            $academia = $row["nombre"];     
            array_push($arregloAcademias, $academia);
            #echo($academia);
        }
        $resultado = json_encode($arregloAcademias);
        echo($resultado);
        //ESTO ES LO QUE SE IMPRIME, ¿DE DONDE CHOTAS SALE EL DCIC
        //  DCIC["Ciencias de la Computaci\u00f3n","Ciencia de Datos","Inteligencia Artificial"]
    }

}

?>