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
    <title>Página Principal de Secretarias</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['user_name']; ?>!</h2>
    <p>Contenido de la página principal de secretarias...</p>
    <a href="Logout.php">Cerrar sesión</a>
</body>
</html>
