<?php
include "php/utils/conexion.php";

$q = "CALL createProfesor('2000637777', 'Prueboso', 'DISC');";
$a=$mysql->query($q);
var_dump($a->fetch_assoc());
?>