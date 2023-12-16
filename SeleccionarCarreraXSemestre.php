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
    <title>Formulario</title>
    <style>
        label {
            display: block;
            margin-bottom: 8px;
        }
    </style>
    <script>
        function cargarGradosYGrupos() {
            // Obtener el valor seleccionado de la carrera
            var carreraSeleccionada = document.getElementById("carrera").value;

            // Realizar la solicitud AJAX para obtener los grados y grupos
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Limpiar las opciones actuales en los select de semestre y grupo
                    document.getElementById("semestre").innerHTML = "";
                    document.getElementById("grupo").innerHTML = "";

                    // Parsear la respuesta JSON
                    var data = JSON.parse(this.responseText);

                    // Llenar el select de semestre con los datos obtenidos
                    for (var i = 0; i < data.semestres.length; i++) {
                        var option = document.createElement("option");
                        option.value = data.semestres[i];
                        option.text = data.semestres[i];
                        document.getElementById("semestre").appendChild(option);
                    }

                    // Llenar el select de grupo con los datos obtenidos
                    for (var i = 0; i < data.grupos.length; i++) {
                        var option = document.createElement("option");
                        option.value = data.grupos[i];
                        option.text = data.grupos[i];
                        document.getElementById("grupo").appendChild(option);
                    }
                }
            };

            xhr.open("GET", "obtener_grados_grupos.php?carrera=" + carreraSeleccionada, true);
            xhr.send();
           
        }
    </script>
</head>

<body>
    <form action="ListaAlumnos.php" method="post">
        <label for="carrera">Carrera:</label>

        <?php
        try {
            // Utiliza la función conectarDB de funciones.php
            include 'funciones.php'; // Asegúrate de incluir el archivo funciones.php
            $conexion = conectarDB();

            // Consulta para obtener las carreras
            $consulta = $conexion->query("SELECT Clave, Nombre FROM formacion");
            $consulta_alumnos = $conexion->query("SELECT a.* FROM alumnos a INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno INNER JOIN materias m ON c.Clave_Materia = m.Clave INNER JOIN formacion f ON m.ClaveFormacion = f.Clave;");
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        } finally {
            // No es necesario cerrar la conexión en este punto, ya que se hará automáticamente al final del script.
        }
        ?>

    <select class="controls" id="carrera" name="carrera" required onchange="cargarGradosYGrupos()">
            <?php
            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['Clave']}'>{$row['Nombre']}</option>";
            }
            ?>
        </select>

        <select class="controls" id="semestre" name="semestre" required></select>

        <select class="controls" id="grupo" name="grupo" required></select>

        <input type="submit" value="Enviar">
    </form>
</body>

</html>
