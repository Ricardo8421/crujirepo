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
function checkCredentials(String $username, String $password) : int {
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
			$shouldRedirect = true;
            return $row['permiso'];
		}
	}

    return 0;
}

/*
 * Checa las credenciales y regresa a dónde debería regresar
 * 
 * @param String $username El nombre de usuario
 * 
 * @param String password La contraseña
 * 
 * @returns String La ruta del php al que se debería regresar
*/
function login(String $username, String $password) : String {
    $permiso = checkCredentials($username, $password);

    if ($permiso != 0) {
        $_SESSION["usuario"] = $username;
        $_SESSION["contra"] = $password;
    }

    return getRedirect($permiso);
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
function checkSession(int $nivel) : String {
    $permiso = checkCredentials($_SESSION['usuario'], $_SESSION['contra']);

    if ($permiso != $nivel) {
        return getRedirect($permiso);
    }

    return null;
}

function getRedirect(int $permiso) : String {
    switch ($permiso) {
        case 1: return "formulario.php";
        case 2: return "profesores.php";
        default: return "";
    }
}

?>