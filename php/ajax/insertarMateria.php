<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

//Problemas
$b=true;

if(isset($_POST["clave"]) && isset($_POST["nombre"]) && isset($_POST["semestre"]) && isset($_POST["academia"]) && isset($_POST["plan"]) && isset($_POST["carrera"])){
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $semestre = $_POST["semestre"];
    $idAcademia = $_POST["academia"];
    $plan = $_POST["plan"];
    $carrera = $_POST["carrera"];   
}else{
    $b=false;
	$r["resultado"] = "Error en los datos, intentelo de nuevo más tarde";
}

if(empty($clave)){
    $b = false;
	$r["resultado"] = "No puedes tener claves vacías";
}

if(empty($nombre)){
    $b = false;
	$r["resultado"] = "No puedes tener nombres vacíos";
}

if($semestre<1 || $semestre>8){
    $b=false;
	$r["resultado"] = "El semestre debe de estar entre 1 y 8";
}

$query = sprintf("SELECT id FROM academia WHERE id=%d",
    $mysql->real_escape_string($idAcademia));
$a = $mysql->query($query);
if($a->num_rows==0){
    $b = false;
	$r["resultado"] = "La academia que ingresaste no existe";
}

if($plan<1999 || $plan>2099){
    $b = false;
	$r["resultado"] = "Solo se aceptan planes entre el 2000 y el 2099";
}

if($carrera != "A" && $carrera != "B" && $carrera != "C"){
    $b=false;
	$r["resultado"] = "La carrerra que ingresaste no existe";
}

if($b){
    $query = sprintf("INSERT INTO Materia (clave, nombre, semestre, academia, plan, carrera) VALUES ('%s', '%s', %d, %d, %d, '%s')",
        $mysql->real_escape_string($clave),
        $mysql->real_escape_string($nombre),
        $mysql->real_escape_string($semestre),
        $mysql->real_escape_string($idAcademia),
        $mysql->real_escape_string($plan),
        $mysql->real_escape_string($carrera)
    );
    if($mysql->query($query)){
        $r["resultado"] = "Registro correcto";
    }else{
        $b = false;
		$r["resultado"] = "Hubo un error en la base de datos, inténtelo de nuevo más tarde";
    }
}

$r["success"]=$b;

$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;

?>