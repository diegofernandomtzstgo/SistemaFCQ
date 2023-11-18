<?php

// login_secretarias.php

// Incluir las funciones
include 'funciones.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar las credenciales
    if (verificarCredencialesSecretarias($usuario, $contrasena)) {
        // Iniciar sesión (puedes implementar tu propio sistema de sesión)
        session_start();
        $_SESSION['usuario_secretarias'] = $usuario;
        
        // Redirigir a la página de inicio o dashboard de secretarias
        header('Location: inicio_secretarias.php');
        exit();
    } else {
        $mensajeError = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
}

// Formulario de inicio de sesión para secretarias
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Secretarias</title>
</head>
<body>

    <h2>Login Secretarias</h2>

    <?php if (isset($mensajeError)) : ?>
        <p style="color: red;"><?php echo $mensajeError; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="usuario">Número de Empleado:</label>
        <input type="text" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>

</body>
</html>
