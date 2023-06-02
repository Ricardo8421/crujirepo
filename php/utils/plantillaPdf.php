<?php
$nombreCompleto = "Juan Perez";
$numeroEmpleado = "123456";
$departamento = "Sistemas y Computación";

$nombreImagen = "../../assets/ipn.png";
$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));
$nombreImagen = "../../assets/Escom.png";
$imagenBase264 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        header{
            background-color: rgb(27,99,149);
            color: #ebebeb;
            text-align:center;
            padding: 4rem;
            font-size: 2rem;
            font-weight: bold;
        }

        h1 {
        font-size: 2rem;
        }
        h2 {
        font-size: 1.5rem;
        text-align: center;

        }
        table{
            padding: 1rem;
            letter-spacing: normal;
        }

        hr{
            border: 2px solid rgb(27,99,149);
        }

        footer{
            background-color: rgb(27,99,149);
            color: #ebebeb;
            align-items: center;
            justify-content: center;
            display: flex;
            padding: 1.5rem;
            font-size: 1rem;
            font-weight: bold;
        }

        .escom{
            width: 20%;
            height: auto;
            padding: 1rem;
            position: fixed;
            right: 0;
        }

        .ipn{
            width: 20%;
            height: auto;
            padding: 2rem;
            position: fixed;
            left: 0;
        }
        .conteiner{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .actividades {
            border-collapse: collapse;
            width: 40%;
        }

        .actividades td, .actividades th {
            padding: 8px;
        }

        .actividades tr:first-child td {
            border-bottom: 2px solid rgb(27,99,149);
        }
        .actividades td {
            border-bottom: 1px solid rgb(27,99,149);
        }

        .actividades td:not(:last-child) {
            border-right: 1px solid rgb(27,99,149);
        }



    </style>

    <header> 
        <img src="<?php echo $imagenBase64 ?>" alt="logo" class="ipn">
        Datos personales
        <img src="<?php echo $imagenBase264 ?>" alt="logo" class="escom">
    </header>
    <table>
        <tr>
            <td>Nombre Completo:</td>
            <td> <?php echo $nombreCompleto; ?></td>
        </tr>
        <tr>
            <td>Numero de empleado:</td>
            <td> <?php echo $numeroEmpleado; ?></td>
        </tr>
        <tr>
            <td>Departamento:</td>
            <td> <?php echo $departamento; ?></td>
        </tr>
    </table>
    <hr/>

    <div class="conteiner">
        <h2>Actividades seleccionadas</h2>
        <table class="actividades">
            <tr>
                <td>No.</td> 
                <td>Actividad</td>
                <td>Horas destinadas</td>
            </tr>
            <tr>
                <td>1</td> 
                <td>Contar chistes</td>
                <td>10</td>
            </tr>
            <tr>
                <td>2</td> 
                <td>ArremangalaArrepungalaArremagala</td>
                <td>10</td>
            </tr>
        </table>
    </div>
    <footer>
        <p>
            "La tecnica al servicio de la patria"
        </p>
    </footer>
</body>
</html>
