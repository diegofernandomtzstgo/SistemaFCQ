<?php
// Incluir el archivo que contiene la función
include('funciones.php');

// Verificar si se han proporcionado los parámetros
if (isset($_GET['numEmpProfesor']) && isset($_GET['nombreMateria'])) {
    // Obtener parámetros
    $numEmpProfesor = $_GET['numEmpProfesor'];
    $nombreMateria = $_GET['nombreMateria'];

    // Obtener detalles de la materia
    $resultados = obtenerDetallesMateria($numEmpProfesor, $nombreMateria);
} else {
    // Manejar el caso de parámetros no proporcionados
    echo "Se requieren parámetros numEmpProfesor y nombreMateria.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Materia</title>
    <!-- Agregar estilos CSS según sea necesario -->
</head>
<body>

<h1>Detalles de la Materia</h1>

<?php
if ($resultados) {
    // Mostrar resultados en una tabla
    echo "<table border='1'>
            <tr>
                <th>Clave Materia</th>
                <th>Nombre Materia</th>
                <th>Matricula Alumno</th>
                <th>Nombre Alumno</th>
                <th>Apellido Alumno</th>
                <th>Calificacion</th>
                <th>Ciclo Escolar</th>
            </tr>";

    foreach ($resultados as $resultado) {
        echo "<tr>
                <td>{$resultado['ClaveMateria']}</td>
                <td>{$resultado['NombreMateria']}</td>
                <td>{$resultado['MatriculaAlumno']}</td>
                <td>{$resultado['NombreAlumno']}</td>
                <td>{$resultado['ApellidoAlumno']}</td>
                <td>{$resultado['Calificacion']}</td>
                <td>{$resultado['Ciclo_Escolar']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    // Manejar el caso de error
    echo "Error al obtener los detalles de la materia.";
}
?>

</body>
</html>
