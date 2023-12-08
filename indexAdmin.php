<?php
session_start();

// Verificar la sesión del administrador
if (!isset($_SESSION['admin_usuario']) || empty($_SESSION['admin_usuario'])) {
    header("Location: LoginAdmin.php");
    exit();
}

// Verificar el tiempo de inactividad y cerrar sesión si es necesario
$inactivity_timeout = 1800; // 30 minutos (en segundos)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivity_timeout)) {
    session_unset();
    session_destroy();
    header("Location: LoginAdmin.php");
    exit();
}

// Actualizar el tiempo de actividad
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['admin_usuario']; ?>!</h2>

   
    <div class="contenedor">
    <div class="parte">Ingresar Admin<br><br>
            <div class="parte2"><a href="AgregarAdmin.php"><img src="iconos/admin.png" width="110"></a></div>
        </div>
        <div class="parte">Editar Admin<br><br>
            <div class="parte2"><a href="EditarAdmin.php"><img src="iconos/editar_admin.png" width="100"></a></div>
        </div>
        <div class="parte">Eliminar Admin<br><br>
            <div class="parte2"><a href="eliminarAdmin.php"><img src="iconos/eliminar_admin.png" width="100"></a></div>
            
        </div>
        <div class="parte">Agregar Secretaria<br><br>
            <div class="parte2"><a href="AgregarSecretaria.php"><img src="iconos/secre.png" width="100"></a></div>
            
        </div>

        <div class="parte">Editar Secretaria<br><br>
            <div class="parte2"><a href="EditarSecretarias.php"><img src="iconos/editar_secre.png" width="100"></a></div>
            
        </div>
      
        <div class="parte">Eliminar Secretaria<br><br>
            <div class="parte2"><a href="eliminar_secretaria.php"><img src="iconos/eliminar_secretaria.png" width="100"></a></div>
            
        </div>

        <div class="parte">Agregar Profesor<br><br>
            <div class="parte2"><a href="Agregarprofesor.php"><img src="iconos/profesor_add.png" width="100"></a></div>
            
        </div>

        
        <div class="parte">Editar Profesor<br><br>
            <div class="parte2"><a href="EditarProfesores.php"><img src="iconos/editprof.png" width="100"></a></div>

               
        <div class="parte">Eliminar Profesor<br><br>
            <div class="parte2"><a href="EliminarProfesores.php"><img src="iconos/deleteprof.png" width="100"></a></div>
            
        </div>
        </div>
        </div>
    </div>
=======
    
    <p>Contenido del panel de administrador...</p>
>>>>>>> 2066549b4b2bffd5b0d48a34affe8ee3a44a5e07

    <a href="LogoutAdmin.php">Cerrar sesión</a>
</body>
</html>
