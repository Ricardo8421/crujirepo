<!DOCTYPE html>
<html lang="en">
<?php
include "php/utils/login.php";
session_start();

$redirect = checkSession(1);

if (!is_null($redirect)) {
	header("Location: ./" . $redirect);
}

?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de profesores</title>

    <link rel="stylesheet" href="css/reset.css">
    <!---<link rel="stylesheet" href="css/formulario_styles.css">--->
<link rel="stylesheet" href="css/formulario_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a0a5eb5331.js" crossorigin="anonymous"></script>

</head>

<header Content-Type:="utf-8">

    <nav class="navbar bg-dark-escom">
        <div class="container-fluid">
            <a class="navbar-brand text-light">Sistema de profesores</a>
            <form action="logout.php" class="d-flex" method="post">
                <input type="hidden" value="cerrarsesion" name="cs">
                <button class="btn btn-success" type="submit">Cerrar sesión</button>
            </form>
        </div>
    </nav>
</header>

<body class="bg-lighter-escom">
    <h1 class="text-center my-5  .registry-header__logo">Encuesta para docentes ESCOM</h1>

    <div class="container-scroll">
        <div class="container ">
            <form method="post" action="/registroConcluido.php" class="formulario flex flex--column"
                autocomplete="off" id="form">
                <section class="bg-lighter-escom py-5 carta d-flex  style="background-color:#fff;">
                    <h4 class="my-4">Selección de academia</h4>
                    <div class=" container container-formulario">
                        <label for="academia">Acdemia:</label>
                        <select
                            class="form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px "
                            aria-label="Default select example"
                            style="background-color: var(--background-color); color: var( --contrast-dark-color);"
                            id="academia">
                            <?php
							$result = $mysql->query("SELECT nombre FROM academia");
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
							?>
                            <option>
                                <?php echo $row["nombre"] ?>
                            </option>
                            <?php
								}
							}
							?>
                        </select>
                    </div>
                </section>
                <section class="bg-lighter-escom py-5 carta">
                    <div class="container" id="carta">
                        <h2>Materias</h2>
                        <p>Selecciona las materias que estás interesado en impartir:</p>
                        <div class="container container-formulario">
                            <div id="materias" class="container container-formulario">
                                <label for="materia">Indique las materrias a registar</label>
                            </div>
                        </div>
                    </div>
                    <label for="materias_extra">¿Desea registra mas materias?</label>
                    <input type="checkbox" id="materias_extra" name="materias_extra">


                    <label for="materias_pp" id="materias_pp_label" style="display: none;"> Agregar mas
                        materrias</label>
                    <input type="checkbox" id="materias_pp" name="materias_pp" style="display: none;">
                    <label for="materias_ll" id="materias_ll_label" style="display: none;"> Quitar materrias</label>
                    <input type="checkbox" id="materias_ll" name="materias_ll" style="display: none;">
                </section>
                <section id="actividades" class="py-5 carta">
                    <div class="container">
                        <h2>Actividades de desempeño</h2>
                        <p>Selecciona las actividades que realizarás durante el semestre:</p>
                        <div class="form-group">
                            <label for="actividad1">Actividad 1</label><br>
                            <select
                                class="form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px "
                                aria-label="Default select example"
                                style="background-color: var(--background-color); color: var( --contrast-dark-color);"
                                id="actividad1" name="actividad" required>
                                <option value="Prepearacion de clases">Prepearacion de clases</option>
                            </select>
                            <label for="horas_actividad1">Horas dedicadas a la actividad 1</label>
                            <input type="number" class="form-control border-primary" id="horas_actividad1"
                                name="horas_actividad2" min="0" max="22" required>
                            <div id="horas_actividad1-error" class="error-message" style="color:red"></div>
                            <small class="form-text text-muted">Ingrese el número de horas que dedicará a la actividad
                                seleccionada.
                                La suma total de horas para todas las actividades adicionales no debe exceder de 22
                                horas.</small>
                        </div>
                        <div class="form-group">
                            <label for="actividad2">Actividad 2</label><br>

                            <select
                                class="form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px "
                                aria-label="Default select example"
                                style="background-color: var(--background-color); color: var( --contrast-dark-color);"
                                id="actividad2" name="actividad" required>
                                <option value="Atencion a alumnos">Atención a alumnos</option>
                            </select>
                            <label for="horas_actividad2">Horas dedicadas a la actividad 2</label>
                            <input type="number" class="form-control border-primary" id="horas_actividad2"
                                name="horas_actividad2" min="0" max="22" required>
                            <div id="horas_actividad2-error" class="error-message" style="color:red"></div>

                        </div>
                        <div class="form-group">
                            <label for="actividad3">Actividad 3</label>
                            <select
                                class="form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px "
                                aria-label="Default select example"
                                style="background-color: var(--background-color); color: var( --contrast-dark-color);"
                                id="actividad3" name="actividad">
                                <option value="">Seleccionar actividad</option>
                                <option value="tutorias">Tutorías</option>
                                <option value="elaboracion_examenes">Elaboración de exámenes</option>
                                <option value="revision_examenes">Revisión de exámenes</option>
                                <option value="otros">Otros</option>
                            </select>
                            <small class="form-text text-muted">Seleccione una actividad adicional a "Preparación de
                                clases" y
                                "Atención a alumnos".</small>
                        </div>

                        <div class="form-group">
                            <label for="horas_actividad3">Horas dedicadas a la actividad 3</label>
                            <input type="number" class="form-control border-primary" id="horas_actividad3"
                                name="horas_actividad3" min="0" max="22">
                            <div id="horas_actividad3-error" class="error-message" style="color:red"></div>

                        </div>

                        <div class="form-group">
                            <label for="actividad4">Actividad 4</label>
                            <select
                                class="form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px "
                                aria-label="Default select example"
                                style="background-color: var(--background-color); color: var( --contrast-dark-color);"
                                id="actividad4" name="actividad">
                                <option value="">Seleccionar actividad</option>
                                <option value="tutorias">Tutorías</option>
                                <option value="elaboracion_examenes">Elaboración de exámenes</option>
                                <option value="revision_examenes">Revisión de exámenes</option>
                                <option value="otros">Otros</option>
                            </select>
                            <small class="form-text text-muted">Seleccione una actividad adicional a "Preparación de
                                clases",
                                "Atención a alumnos" y "Actividad 3".</small>
                        </div>

                        <div class="form-group">
                            <label for="horas_actividad4">Horas dedicadas a la actividad 4</label>
                            <input type="number" class="form-control border-primary" id="horas_actividad4"
                                name="horas_actividad4" min="0" max="22">
                            <div id="horas_actividad4-error" class="error-message" style="color:red"></div>

                        </div>

                        <div class="form-group">
                            <label for="actividad5">Actividad 5</label>
                            <select
                                class="form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px "
                                aria-label="Default select example"
                                style="background-color: var(--background-color); color: var( --contrast-dark-color);"
                                id="actividad5" name="actividad">
                                <option value="">Seleccionar actividad</option>
                                <option value="tutorias">Tutorías</option>
                                <option value="elaboracion_examenes">Elaboración de exámenes</option>
                                <option value="revision_examenes">Revisión de exámenes</option>
                                <option value="otros">Otros</option>
                            </select>
                            <small class="form-text text-muted">Seleccione una actividad adicional a "Preparación de
                                clases",
                                "Atención a alumnos", "Actividad 3" y
                                "Actividad 4".</small>
                        </div>
                        <div class="form-group">
                            <label for="horas_actividad5">Horas dedicadas a la actividad 5</label>
                            <input type="number" class="form-control border-primary" id="horas_actividad5"
                                name="horas_actividad5" min="0" max="22">
                            <div id="horas_actividad5-error" class="error-message" style="color:red" ;></div>

                        </div>
                    </div>

                </section>
                <button type="submit" class="button__submit btn-primary wave">Enviar</button>
            </form>
        </div>

        <script src="js/validate_data.js"></script>
        <script src="js/both_js2.js" type="module"></script>

</body>

</html>