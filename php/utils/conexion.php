<?php
$mysql = new mysqli("localhost", "root", "ln0m3l0.", "Cuestionarios");
mysqli_set_charset($mysql, 'utf8');

if($mysql -> connect_error){
    die("Hubo un error al conectarse a la base de datos");
}
?>