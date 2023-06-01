<?php
    require "../utils/login.php";
    header('Content-type: application/json; charset=UTF-8');

    session_start();

    $permiso = login($_POST["usuario"], $_POST["contrasena"]);

    $co = [];
    $co["permiso"] = $permiso;
    if ($permiso == 0) {
        $co["error"] = $_POST["contrasena"];
        $co["redirectTo"] = $_POST["usuario"];
        echo json_encode($co);
    } else {
        $redirect = getRedirect($permiso);
        $co["error"] = null;
        $co["redirectTo"] = $redirect;
        echo json_encode($co);
    }
?>  