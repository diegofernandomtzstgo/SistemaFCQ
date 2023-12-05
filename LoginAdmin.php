<?php
include('funciones.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['Usuario']) ? filter_var($_POST['Usuario'], FILTER_SANITIZE_STRING) : '';
    $password = isset($_POST['Password']) ? filter_var($_POST['Password'], FILTER_SANITIZE_STRING) : '';

    if (empty($usuario) || empty($password)) {
        $mensaje_error = "Por favor, completa todos los campos.";
    } else {
        $admin_valido = consultarLoginAdmin($usuario, $password);

        if ($admin_valido) {
            session_start();
            session_regenerate_id();
            $_SESSION = array();

            
            $_SESSION['admin_usuario'] = $admin_valido['Usuario'];

            header("Location: IndexAdmin.php");
            exit();
        } else {
            $mensaje_error = "Usuario o contraseña incorrectos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Administrador</title>
</head>
<body>
    <h2>Login de Administrador</h2>
    
    <?php if (isset($mensaje_error)): ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php endif; ?>

    <form action="LoginAdmin.php" method="post">
        <label for="Usuario">Usuario:</label>
        <input type="text" id="Usuario" name="Usuario" required>
        <br>
        <label for="Password">Contraseña:</label>
        <input type="password" id="Password" name="Password" required>
        <br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
