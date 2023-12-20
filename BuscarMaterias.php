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

// Realizar la consulta para obtener los ciclos escolares
include('funciones.php');
$conexion = conectarDB();
$consultaCiclos = obtenerCiclosEscolares();
$consultaSemestres = obtenerSemestre();
$consultaGrupos = obtenerGrupo();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Materias</title>
</head>

<body>
<div>
    <form action="ListaMateriasCiclo.php" method="post">
       
        <br>
        <label for="ciclo_escolar">Ciclo Escolar:</label>
            <select id="ciclo_escolar" name="ciclo_escolar" required>
                <?php
                    while ($row = $consultaCiclos->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['Ciclo_Escolar']}'>{$row['Ciclo_Escolar']}</option>";
                    }
                ?></select>
            <label for="Semestre">Semestre:</label>
            <select id="Semestre" name="Semestre" required>
                <?php
                while ($row = $consultaSemestres->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['Semestre']}'>{$row['Semestre']}</option>";
                } ?></select>

            <label for="Grupo">Grupo:</label>
            <select id="Grupo" name="Grupo" required><?php
                while ($row = $consultaGrupos->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['Grupo']}'>{$row['Grupo']}</option>";
                }
                ?>
            </select>
        <button type="submit">Entrar</button>
    </form>
</div>
</body>
</html>