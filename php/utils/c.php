<?php
//action="FormularioDatosEnvio.php"
include "conexion.php";

$variable= $_POST['valor'];
$result = $mysql->query("SELECT horasMinimas FROM actividad where id='$variable'");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $horasMinimas = $row["horasMinimas"];
             echo $horasMinimas;
    }
}
?>