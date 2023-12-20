<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: LoginSecretarias.php");
    exit();
}

$inactive_time = 1800;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_time)) {
    // Si ha pasado demasiado tiempo, cerrar sesión
    session_unset();
    session_destroy();
    header("Location: LoginSecretarias.php");
    exit();
}

// Actualizar la marca de tiempo de la última actividad
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista alumnos</title>
</head>

<body>
<?php 
    $matriculalumno = isset($_GET['Matricula_Alumno']) ? filter_var($_GET['Matricula_Alumno'], FILTER_SANITIZE_STRING) : '';
    $carrera = isset($_GET['Clave']) ? filter_var($_GET['Clave'], FILTER_SANITIZE_STRING) : '';
    $semestre = isset($_GET['Semestre']) ? filter_var($_GET['Semestre'], FILTER_SANITIZE_STRING) : '';
    $grupo = isset($_GET['Grupo']) ? filter_var($_GET['Grupo'], FILTER_SANITIZE_STRING) : '';

    echo "Matricula del Alumno: " . $matriculalumno . "<br>";
    echo "Carrera: " . $carrera . "<br>";
    echo "Semestre: " . $semestre . "<br>";
    echo "Grupo: " . $grupo . "<br>";
    include('funciones.php');
    $registros = consultarAlumnosWhereMatricula($matriculalumno);
?>

<form method="POST" action="Actualizaralumnos.php">
    <label for="matricula">Matrícula:</label><br>
    <input type="number" id="matricula" name="matricula" min="100000" max="999999" value="<?php echo $registros['Matricula'];?>" placeholder="Ingrese nueva matricula" required><br>
    <br>
    <label for="nombre">Nombre:</label><br>
    <input class="controls" type="text" id="nombre" name="nombre" value="<?php echo $registros['Nombre'];?>" placeholder="Ingrese nuevo nombre" required> </input>
    <label for="apellidos">Apellidos:</label><br>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $registros['Apellido'];?>" placeholder="Ingrese nuevo apellido" required><br>

    <label for="telefono">Teléfono:</label><br>
    <input type="number" id="telefono" name="telefono" value="<?php echo $registros['Telefono'];?>" placeholder="Ingrese nuevo telefono celular" required><br>
    <label for="correo">Correo:</label><br>
    <input type="email" id="correo" name="correo" value="<?php echo $registros['Correo'];?>" placeholder="Ingrese nuevo correo" required><br>
    <label for="grupo">Grupo:</label><br>
    <input type="text" id="grupo1" name="grupo1" value="<?php echo $registros['Grupo'];?>" placeholder="Ingrese nuevo grupo" required><br>
    <label for="semestre">Semestre:</label><br>
    <input type="number" id="semestre1" name="semestre1" min="1" max="12" value="<?php echo $registros['Semestre'];?>" placeholder="Ingrese nuevo semestre" required><br>
    <input type="submit" value="Editar">
    <p>Campos vacíos implican que la base de datos se actualizará con datos vacíos. Precaución</p>
</form>

</body>
</html>

