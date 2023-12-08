<?php
include('funciones.php');
session_start(); // Inicia la sesión al principio del script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numEmp = isset($_POST['NumEmp']) ? filter_var($_POST['NumEmp'], FILTER_SANITIZE_STRING) : '';
    $password = isset($_POST['Password']) ? filter_var($_POST['Password'], FILTER_SANITIZE_STRING) : '';

    if (empty($numEmp) || empty($password)) {
        $mensaje_error = "Por favor, completa todos los campos.";
    } else {
        $usuario_valido = consultarLoginProfesores($numEmp,$password);

        if ($usuario_valido && $password === $usuario_valido['Password']) {
            // session_start(); // No es necesario volver a iniciar la sesión aquí
            session_regenerate_id();
            $_SESSION = array();

            $_SESSION['user_id'] = $usuario_valido['NumEmp'];
            $_SESSION['user_name'] = $usuario_valido['Nombre'];

            header("Location: IndexProfesores.php");
            exit();
        } else {
            $mensaje_error = "Credenciales incorrectas";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Profesores</title>
</head>
<body>
    <h2>Login de Profesores</h2>
    
    <?php if (isset($mensaje_error)): ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php endif; ?>

    <form action="LoginProfesores.php" method="post">
        <label for="NumEmp">Número de empleado:</label>
        <input type="text" id="NumEmp" name="NumEmp" required>
        <br>
        <label for="Password">Contraseña:</label>
        <input type="password" id="Password" name="Password" required>
        <br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
