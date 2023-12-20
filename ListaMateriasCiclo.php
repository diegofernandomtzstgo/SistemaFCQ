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
    <title>Lista Materias</title>
    <style>
    table {
        width: 700px;
        border-collapse: collapse;
        margin: 20px;
        font-family: Arial, sans-serif;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #e0e0e0;
    }

</style>
</head>

<body>

<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir el ciclo escolar seleccionado
    $cicloEscolar = $_POST["ciclo_escolar"];
    $semestre = $_POST["Semestre"];
    $grupo = $_POST["Grupo"];

    include('funciones.php');
    $conexion = conectarDB();

    // Consulta para obtener las materias del ciclo escolar
    $sql = "SELECT DISTINCT M.Clave, M.Nombre 
            FROM CURSAR C 
            INNER JOIN MATERIAS M ON C.Clave_Materia = M.Clave 
            INNER JOIN ALUMNOS A ON C.Matricula_Alumno = A.Matricula 
            WHERE A.Semestre = :semestre AND A.Grupo = :grupo AND C.Ciclo_Escolar = :ciclo";

    $statement = $conexion->prepare($sql);
    $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->bindParam(':ciclo', $cicloEscolar, PDO::PARAM_STR);
    $statement->execute();
    $consultaMaterias = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Imprimir el título y la tabla de materias
    echo "<h2>Materias del Ciclo: $cicloEscolar del $semestre $grupo </h2>";
    echo "<table border='1'>
            <tr>
                <th>Materia</th>
                <th>Imprimir</th>
            </tr>";

            foreach ($consultaMaterias as $rowMaterias) {
                echo "<tr>
                        <td>{$rowMaterias['Nombre']}</td>
                        <td>
                            <a href='PdfKardexPorMateria.php?Clave_Materia={$rowMaterias['Clave']}&Ciclo_Escolar=$cicloEscolar&Semestre=$semestre&Grupo=$grupo&Materia={$rowMaterias['Nombre']}'>
                            <img src='iconos/pdf.png' width='32' height='32' alt='Imprimir'>
                            </a>
                        </td>
                    </tr>";
            }

    echo "</table>";
}
?>

</body>
</html>
