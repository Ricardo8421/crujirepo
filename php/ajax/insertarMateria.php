<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

//Problemas
$b=true;

$clave = "Cum";
$nombre = "Comedia I";
$semestre = "2";
$idAcademia = "4";
$plan = "2006";
$carrera = "B";

if(isset($_POST["clave"]) && isset($_POST["nombre"]) && isset($_POST["semestre"]) && isset($_POST["academia"]) && isset($_POST["plan"]) && isset($_POST["carrera"])){
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $semestre = $_POST["semestre"];
    $idAcademia = $_POST["academia"];
    $plan = $_POST["plan"];
    $carrera = $_POST["carrera"];   
}else{
    $b=false;
}

if(empty($clave) || empty($nombre)){
    $b = false;
}

if($semestre<1 || $semestre>8){
    echo "nel";
    $b=false;
}

$query = "SELECT id FROM academia";
$a = $mysql->query($query);
if($a->num_rows>0){
    $b2 = false;
    while($f = $a->fetch_assoc()){
        if($idAcademia==$f["id"]){
            $b2=true;
            break;
        }
    }
    if(!$b2){
        $b=false;
    }
}else{
    $b=false;
}

if($plan<1999 || $plan>2099){
    $b = false;
}

if($carrera != "A" && $carrera != "B" && $carrera != "C"){
    $b=false;
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
    }
}

if(!$b){
    $r["resultado"] = "Algo salió mal";
}

$json = json_encode($r, JSON_UNESCAPED_UNICODE);

echo $json;

?>