<?php
include "conexion.php";

/*
 * Checa las credenciales y regresa el permiso que tiene. Regresa 0 si no está registrado el usuario
 * 
 * @param String $username El nombre de usuario
 * 
 * @param String password La contraseña
 * 
 * @returns int El nivel del permiso que tiene. 0 si no está registrado.
*/
function checkCredentials(String $username = null, String $password = null) : int {
	if (is_null($username) || is_null($password)) {
		return 0;
	}
	
    $mysql = $GLOBALS['mysql'];

    $query = sprintf(
		"SELECT permiso, accesoCongelado 
        FROM usuario LEFT OUTER JOIN profesor ON usuario.id=profesor.idUsuario 
        WHERE login='%s' AND pass='%s'",
		$mysql->real_escape_string($username),
		$mysql->real_escape_string($password)
	);

	$result = $mysql -> query($query);

    if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
            if($row['accesoCongelado']==1){
                return 3;
            }
            return $row['permiso'];
		}
	}

    return 0;
}

/*
 * Checa las credenciales y regresa el permiso que tiene
 * 
 * @param String $username El nombre de usuario
 * 
 * @param String password La contraseña
 * 
 * @returns int El permiso que tiene el usuario. 0 Si no existe
*/
function login(String $username = null, String $password = null) : int {
    $permiso = checkCredentials($username, $password);

    if ($permiso != 0 && $permiso != 3) {
        $_SESSION["usuario"] = $username;
        $_SESSION["contra"] = $password;
    }

    return $permiso;
}

/*
 * Checa las credenciales guardadas en la sesion
 * 
 * 
 * @returns int Nivel de permiso que tiene si ha iniciado sesión. 0 si no ha iniciado
 * 
*/
function checkLoggedIn() : int {
    if (!isset($_SESSION["usuario"]) || !isset($_SESSION["contra"])) {
  	    session_destroy();
        return 0;
    }

    return checkCredentials($_SESSION['usuario'], $_SESSION['contra']);
}

/*
 * Checa las credenciales guardadas en la sesion
 * 
 * @param int $nivel El nivel al que la página debería estar
 * 
 * @returns String La dirección a la que se tiene que redireccionar si es que no queda el permiso.
 *          Regresa null si no necesita redireccionar
 * 
*/
function checkSession(int $nivel) {
    if (!isset($_SESSION["usuario"]) || !isset($_SESSION["contra"])) {
  	    session_destroy();
        return "";
    }

    $permiso = checkCredentials($_SESSION['usuario'], $_SESSION['contra']);

    if ($permiso != $nivel) {
        return getRedirect($permiso);
    }

    return null;
}

/*
 * Regresa la página por default para redireccionar
 * 
 * @param int $permiso El permiso que tiene el usuario
 * 
 * @returns String La dirección a la que le corresponde al permiso.
 * 
*/
function getRedirect(int $permiso) : String {
    switch ($permiso) {
        case 1: return "profesor";
        case 2: return "Seleccion_admin";
        default: return "";
    }
}

?>