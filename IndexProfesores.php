<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: LoginProfesores.php");
    exit();
}

$inactive_time = 1800;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_time)) {
    // Si ha pasado demasiado tiempo, cerrar sesión
    session_unset();
    session_destroy();
    header("Location: LoginProfesores.php");
    exit();
}

// Actualizar la marca de tiempo de la última actividad
$_SESSION['last_activity'] = time();

// Obtener el número de empleado del profesor que ha iniciado sesión
$numEmpProfesor = $_SESSION['user_id'];

include 'funciones.php';

// Llamar a la función para obtener los laboratorios del profesor
$laboratoriosProfesor = obtenerLaboratorioPorNumEmp($numEmpProfesor);

// Asegúrate de tener el nombre del profesor disponible en $_SESSION['nombre']
$_SESSION['nombre'] = obtenerNombreProfesor($numEmpProfesor);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index de Profesores</title>
</head>
<body>

    <h2>Bienvenido, Profesor <?php echo $_SESSION['nombre']; ?>!</h2>

    <?php if ($laboratoriosProfesor) : ?>
        <p>Estás asignado a los siguientes laboratorios:</p>
        <ul>
            <?php foreach ($laboratoriosProfesor as $laboratorio) : ?>
                <li><?php echo $laboratorio['Laboratorio']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No estás asignado a ningún laboratorio.</p>
    <?php endif; ?>

    <!-- Resto de tu contenido del index -->

    <a href="LogoutProfesores.php">Cerrar sesión</a>
</body>
</html>
