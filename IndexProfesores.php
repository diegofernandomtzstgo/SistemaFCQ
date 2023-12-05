
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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Profesores</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['user_name']; ?>!</h2>
    

    <p>Contenido exclusivo para profesores.</p>

    <form action="Logoutprofesores.php" method="post">
        <input type="submit" value="Cerrar sesión">
    </form>
</body>
</html>
