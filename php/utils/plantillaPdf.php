<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion Ingresada</title>
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
            width: auto;
        }

        .actividades td, .actividades th {
            padding: 8px;
        }

        .actividades tr:first-child td {
            border-bottom: 2px solid rgb(27,99,149);
        }

        .actividades td:not(:last-child) {
            border-right: 1px solid rgb(27,99,149);
        }



    </style>

    <header> 
        <img src="../../assets/Escom.png" alt="logo" class="ipn">
        Datos personales
        <img src="../../assets/Ipn.png" alt="logo" class="escom">
    </header>
    <table>
        <tr>
            <td>Nombre Completo:</td>
            <td>{{ $nombreCompleto }}</td>
        </tr> 
        <tr>
            <td>Numero de empleado:</td>
            <td>{{ $numeroEmpleado }}</td>
        </tr>
        <tr>
            <td>Departamento:</td>
            <td>{{ $departamento }}</td>
        </tr>
    </table>
    <hr/>
        <h2>Materias seleccionadas</h2>
        <table class="actividades">
            <tr>
                <td>No.</td> 
                <td>Materia</td>
                <td>Academia</td>
            </tr>
            <tr>
                <td>{{ $materia1 }}</td> 
                <td>{{ $nombreM1 }}</td>
                <td>{{ $academiaM1 }}</td>
            </tr>
            <tr>
                <td>{{ $materia2 }}</td> 
                <td>{{ $nombreM2 }}</td>
                <td>{{ $academiaM2 }}</td>
            </tr>
            <tr>
                <td>{{ $materia3 }}</td> 
                <td>{{ $nombreM3 }}</td>
                <td>{{ $academiaM3 }}</td>
            </tr>
            <tr>
                <td>{{ $materia4 }}</td> 
                <td>{{ $nombreM4 }}</td>
                <td>{{ $academiaM4 }}</td>
            </tr>
        </table>
        <h2>Actividades seleccionadas</h2>
        <table class="actividades">
            <tr>
                <td>No.</td> 
                <td>Actividad</td>
                <td>Horas</td>
            </tr>
            <tr>
                <td>{{ $actividad1 }}</td> 
                <td>{{ $nombreA1 }}</td>
                <td>{{ $horasA1 }}</td>
            </tr>
            <tr>
                <td>{{ $actividad2 }}</td> 
                <td>{{ $nombreA2 }}</td>
                <td>{{ $horasA2 }}</td>
            </tr>            
            <tr>
                <td>{{ $actividad3 }}</td> 
                <td>{{ $nombreA3 }}</td>
                <td>{{ $horasA3 }}</td>
            </tr>
            <tr>
                <td>{{ $actividad4 }}</td> 
                <td>{{ $nombreA4 }}</td>
                <td>{{ $horasA4 }}</td>
            </tr>
            </tr>
                <td>{{ $actividad5 }}</td>
                <td>{{ $nombreA5 }}</td>
                <td>{{ $horasA5 }}</td>
            </tr>
        </table>
    <footer>
        <p>
            "La tecnica al servicio de la patria"
        </p>
    </footer>
</body>
</html>
