<?php
//action="FormularioDatosEnvio.php"
include "php/utils/login.php";
$variable = $_GET['variable'];
$result = $mysql->query("SELECT horasMinimas FROM actividad where id='$variable'");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $horasMinimas = $row["horasMinimas"];
             echo $horasMinimas;
        

    }
}
?>