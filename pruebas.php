<?php
include "php/utils/conexion.php";

$a = [];
$a["a"] = [];
$b = 0;
for ($i=0; $i < 10; $i++) { 
    array_push($a["a"], $i);
}

if(in_array($b, $a["a"])){
    echo "La cosa es: ".array_search($b, $a["a"])."<br>";
}

for ($i=0; $i < count($a["a"]); $i++) { 
    echo ((string)$a["a"][$i])."<br>";
}
?>