

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
    <nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Ingresar Alumnos</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
        </ul>
    </nav>
    <div id="contenedor">
    <form method="POST" action="AgregarAlumnos.php">
        <label for="matricula">Matrícula:</label><br>
        <input type="number" id="matricula" name="matricula" min="100000" max="999999" required><br>
        <br>
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" required><br>

        <input type="radio" id="sexo1_femenino" name="sexo1" value="Femenino"> Mujer
        <input type="radio" id="sexo1_masculino" name="sexo1" value="Masculino" required> Hombre


        <label for="telefono">Teléfono:</label><br>
        <input type="number" id="telefono" name="telefono" required><br>
        <label for="correo">Correo:</label><br>
        <input type="email" id="correo" name="correo" required><br>
        <label for="grupo">Grupo:</label><br>
        <input type="text" id="grupo" name="grupo" required><br>
        <label for="semestre">Semestre:</label><br>
        <input type="number" id="semestre" name="semestre" min="1" max="12" required><br>
        <input type="submit" value="Enviar">
    </form>
</div>


</body>
</html>


<?php

include('funciones.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario de login y filtrar
    
        $matricula = isset($_POST['matricula']) ? filter_var($_POST['matricula'], FILTER_SANITIZE_STRING) : '';
        $nombre = isset($_POST['nombre']) ? filter_var($_POST['nombre'], FILTER_SANITIZE_STRING) : '';
		$apellidos = isset($_POST['apellidos']) ? filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING) : '';
		$telefono = isset($_POST['telefono']) ? filter_var($_POST['telefono'], FILTER_SANITIZE_STRING) : '';
		$correo = isset($_POST['correo']) ? filter_var($_POST['correo'], FILTER_SANITIZE_STRING) : '';
        $grupo = isset($_POST['grupo']) ? filter_var($_POST['grupo'], FILTER_SANITIZE_STRING) : '';
        $semestre =isset($_POST['semestre']) ? filter_var($_POST['semestre'], FILTER_SANITIZE_STRING) : '';
		//Determinar Que Opción Se Eligió En Los Radio
		
        if (isset($_REQUEST['sexo1'])) {
            if ($_REQUEST['sexo1'] == "Masculino") {
                $sexo = 'Hombre';
            } else if ($_REQUEST['sexo1'] == "Femenino") {
                $sexo = 'Mujer';
            }
        }       

        // Establecer la conexión a la base de datos
    $conexion = conectarDB();

    if ($conexion) {
        try {
            // Consulta de inserción
            $sql = "INSERT INTO alumnos (Matricula, Nombre, Apellido, Sexo, Telefono, Correo, Semestre, Grupo)
                    VALUES (:matricula, :nombre, :apellido, :sexo, :telefono, :correo, :semestre, :grupo)";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindParam(':apellido', $apellidos, PDO::PARAM_STR);
            $consulta->bindParam(':sexo', $sexo, PDO::PARAM_STR);
            $consulta->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $consulta->bindParam(':correo', $correo, PDO::PARAM_STR);
            $consulta->bindParam(':semestre', $semestre, PDO::PARAM_INT);
            $consulta->bindParam(':grupo', $grupo, PDO::PARAM_STR);

            $consulta->execute();

            $filas = $consulta->rowCount();

            if ($filas > 0) {
                echo "Alumno Agregado";
            } else {
                echo "Hubo un Error al Agregar Alumno!!!";
            }
        } catch (PDOException $e) {
            echo "Error de base de datos: " . $e->getMessage();
        } finally {
            // Cerrar la conexión
            $conexion = null;
        }
    } else {
        echo "Error al conectar a la base de datos";
    }
   
}

?>