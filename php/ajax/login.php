<?php
    require "../utils/login.php";
    header('Content-type: application/json; charset=UTF-8');

    session_start();

    $permiso = (isset($_POST["usuario"]) && isset($_POST["contrasena"])) ?
		 login($_POST["usuario"], $_POST["contrasena"]) : 0;

    $json = [];
    $json["permiso"] = $permiso;

    if ($permiso == 0) {
        $json["error"] = "Usuario o contraseña incorrectos";
        $json["redirectTo"] = "";
        echo json_encode($json);
    }elseif ($permiso == 3) {
        $json["error"] = "Su acceso ha sido bloqueado por un administrador, comuníquese con gestión para descongelárselo";
        $json["redirectTo"] = "";
        echo json_encode($json);
    }else {
        $redirect = getRedirect($permiso);
        $json["error"] = null;
        $json["redirectTo"] = $redirect;
        echo json_encode($json);
    }
?>  