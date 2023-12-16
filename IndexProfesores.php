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

include 'funciones.php';

// Obtener el número de empleado del profesor que ha iniciado sesión
$numEmpProfesor = $_SESSION['user_id'];

// ... Código previo ...

// Llamar a la función para obtener las materias y laboratorios del profesor
$materiasYLaboratorios = obtenerMateriasYLaboratoriosPorNumEmp($numEmpProfesor);

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

    <?php 
    if ($materiasYLaboratorios) {
        // Organizamos los resultados en un array asociativo para evitar duplicados
        $resultados = [];
        foreach ($materiasYLaboratorios as $item) {
            $laboratorio = $item['Laboratorio'];
            $materia = $item['NombreMateria'];

            // Aseguramos que el laboratorio no esté duplicado
            if (!isset($resultados[$laboratorio])) {
                $resultados[$laboratorio] = [];
            }

            // Añadimos la materia al laboratorio correspondiente
            $resultados[$laboratorio][] = $materia;
        }

        echo "<p>Estás asignado a los siguientes laboratorios:</p>";
        echo "<ul>";
        foreach ($resultados as $laboratorio => $materias) {
            echo "<li>$laboratorio";
            if (!empty($materias)) {
                echo " y a las siguientes materias:";
                echo "<ul>";
                foreach ($materias as $materia) {
                    // Modificar el enlace para dirigir a la página de detalles de materia
                    echo "<li><a href='detallesMateria.php?numEmpProfesor=" . urlencode($numEmpProfesor) . "&nombreMateria=" . urlencode($materia) . "'>$materia</a></li>";
                }
                echo "</ul>";
            }
            echo "</li>";
        }
        echo "</ul>";
    }
    ?>

    <a href="LogoutProfesores.php">Cerrar sesión</a>
</body>
</html>