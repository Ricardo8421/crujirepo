<?php
$s = "localhost";
$u = "root";
$c = "n0m3l0";
$b = "cuestionarios";

$xd = new mysqli($s, $u, $c, $b);

if($xd->connect_error){
    die("Hubo un error al conectarse a la base de datos");
}
?>