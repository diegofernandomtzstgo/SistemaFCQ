<?php

//Conexion a la base de datos//

function conectarDB() {
    // Detalles de conexión
    $host = 'localhost';
    $usuario = 'root';
    $password = '';
    $dbname = 'mydb';

    try {
        $conexion = new PDO("mysql:host={$host};dbname={$dbname}", $usuario, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $conexion;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return null;
    }
}


function consultarLoginSecretarias($numEmp, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL


        $consulta = $conexion->prepare("SELECT * FROM secretarias WHERE NumEmp = :numEmp");

        $consulta = $conexion->prepare("SELECT *FROM secretarias WHERE NumEmp = :numEmp");

        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

       
        if ($usuario && $password === $usuario['Password']) {
            return $usuario;
        } else {
            return false;
        }
    } catch (PDOException $e) {
       
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        
        $conexion = null;
    }
}


function eliminarAdmin($id) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("DELETE FROM admin WHERE Id = :id");

        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar esto según tus necesidades)
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}

function agregarSecretaria($numEmp, $nombre, $apellido, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("INSERT INTO secretarias (NumEmp, Nombre, Apellido, Password) VALUES (:numEmp, :nombre, :apellido, :password)");

        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);
        $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $consulta->bindParam(':password', $password, PDO::PARAM_STR);

        $consulta->execute();

        return true;
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar esto según tus necesidades)
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}


function editarSecretaria($numEmp, $nombre, $apellido, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("UPDATE secretarias SET Nombre = :nombre, Apellido = :apellido, Password = :password WHERE NumEmp = :numEmp");

        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);
        $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $consulta->bindParam(':password', $password, PDO::PARAM_STR);

        return $consulta->execute();
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar esto según tus necesidades)
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}

function obtenerSecretariaPorNumEmp($numEmp) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("SELECT * FROM secretarias WHERE NumEmp = :numEmp");
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return null;
    } finally {
        $conexion = null;
    }
}

function obtenerListaSecretarias() {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->query("SELECT * FROM secretarias");
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return array();
    } finally {
        $conexion = null;
    }
}



function eliminarSecretaria($numEmp) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("DELETE FROM secretarias WHERE NumEmp = :numEmp");
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);
        return $consulta->execute();
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        $conexion = null;
    }
}




function agregarProfesor($numEmp, $nombre, $apellidos, $correo, $telefono, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("INSERT INTO profesores (NumEmp, Nombre, Apellidos, Correo, Telefono, Password) VALUES (:numEmp, :nombre, :apellidos, :correo, :telefono, :password)");

        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);
        $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $consulta->bindParam(':correo', $correo, PDO::PARAM_STR);
        $consulta->bindParam(':telefono', $telefono, PDO::PARAM_INT);
        $consulta->bindParam(':password', $password, PDO::PARAM_STR);

        $consulta->execute();

        return true;
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar esto según tus necesidades)
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}



function editarProfesor($numEmp, $nombre, $apellidos, $correo, $telefono, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("UPDATE profesores SET Nombre = :nombre, Apellidos = :apellidos, Correo = :correo, Telefono = :telefono, Password = :password WHERE NumEmp = :numEmp");

        $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $consulta->bindParam(':correo', $correo, PDO::PARAM_STR);
        $consulta->bindParam(':telefono', $telefono, PDO::PARAM_INT);
        $consulta->bindParam(':password', $password, PDO::PARAM_STR);
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);

        return $consulta->execute();
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar esto según tus necesidades)
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}


function obtenerProfesorPorNumEmp($numEmp) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("SELECT * FROM profesores WHERE NumEmp = :numEmp");
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return null;
    } finally {
        $conexion = null;
    }
}

function obtenerListaProfesores() {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->query("SELECT * FROM profesores");
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return array();
    } finally {
        $conexion = null;
    }
}




function consultarLoginProfesores($numEmp, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("SELECT * FROM profesores WHERE NumEmp = :numEmp");
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

       
        if ($usuario && $password === $usuario['Password']) {
            return $usuario;
        } else {
            return false;
        }
    } catch (PDOException $e) {
       
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        
        $conexion = null;
    }
}


function insertarAlumno($matricula, $nombre, $apellidos, $sexo, $telefono, $correo, $semestre, $grupo) {
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
                return "Alumno Agregado";
            } else {
                return "Hubo un Error al Agregar Alumno!!!";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        } finally {
            // Cerrar la conexión
            $conexion = null;
        }
    } else {
        return "Error al conectar a la base de datos";
    }
}
function consultarAlumnos($carrera, $semestre, $grupo) {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $sql = "SELECT a.*, f.Clave
                FROM alumnos a
                INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno
                INNER JOIN materias m ON c.Clave_Materia = m.Clave
                INNER JOIN formacion f ON m.ClaveFormacion = f.Clave
                WHERE f.Clave = :carrera AND a.Semestre = :semestre AND a.Grupo = :grupo";

        // Preparar la declaración
        $statement = $conexion->prepare($sql);
        // Asociar valores a los marcadores de posición
        $statement->bindParam(':carrera', $carrera, PDO::PARAM_STR);
        $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
        $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
        // Ejecutar la consulta
        $statement->execute();
        // Obtener los resultados
        $registros = $statement->fetchAll();

        return $registros;
    } catch (PDOException $e) {


function consultarLoginAdmin($usuario, $password) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("SELECT * FROM admin WHERE Usuario = :usuario");
        $consulta->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        $admin = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password === $admin['Password']) {
            return $admin;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        $conexion = null;
    }
}

function agregarAdmin($nombre, $apellido, $cargo, $usuario, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("INSERT INTO admin (Nombre, Apellido, Cargo, Usuario, Password) VALUES (:nombre, :apellido, :cargo, :usuario, :password)");

        $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $consulta->bindParam(':cargo', $cargo, PDO::PARAM_STR);
        $consulta->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindParam(':password', $password, PDO::PARAM_STR);

        $consulta->execute();

        return true;
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar esto según tus necesidades)

        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}

//Ocupada para ConfirmacionEliminarAlumno.php y EditarAlumnos.php
/*function consultarAlumnosWhereMatricula($matriculalumno) {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $statement = $conexion->prepare("SELECT * FROM alumnos WHERE Matricula = :matricula");
        $statement->bindParam(':matricula', $matriculalumno, PDO::PARAM_INT);
        $statement->execute();
        $registros = $statement->fetch();

        return $registros;
    } catch (PDOException $e) {


function editarAdmin($id, $nombre, $apellido, $cargo, $usuario, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("UPDATE admin SET Nombre = :nombre, Apellido = :apellido, Cargo = :cargo, Usuario = :usuario, Password = :password WHERE Id = :id");

        $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $consulta->bindParam(':cargo', $cargo, PDO::PARAM_STR);
        $consulta->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindParam(':password', $password, PDO::PARAM_STR);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar esto según tus necesidades)

        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }

}*/
function consultarAlumnosWhereMatricula($matriculalumno) {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $statement = $conexion->prepare("SELECT * FROM alumnos WHERE Matricula = :matricula");
        $statement->bindParam(':matricula', $matriculalumno, PDO::PARAM_INT);
        $statement->execute();
        $registros = $statement->fetch();

        // Devolver un array vacío si no hay resultados
        return $registros ? $registros : [];
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return [];  // Devolver un array vacío en caso de error
    } finally {
        // Cerrar la conexión
}

function obtenerListaAdmins() {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->query("SELECT * FROM admin");
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return array();
    } finally {
        $conexion = null;
    }
}




function eliminarAlumnosWhereMatricula($matriculalumno) {
    $conexion = conectarDB();

    try {
        $sql = "DELETE FROM alumnos WHERE Matricula = :Matricula";
		$sql = $conexion->prepare($sql);
		$sql -> bindParam(':Matricula', $matriculalumno,PDO::PARAM_STR);
		$qryExecute = $sql->execute();
		if($qryExecute){
            header("refresh:1;url=IndexSecretarias.php");
            exit("Operación exitosa. Redirigiendo en 1 segundo...");
		}
		else{
            header("refresh:1;url=IndexSecretarias.php");
            exit("Ha ocurrido un error. Redirigiendo en un segundo...");
        }
        return $registros;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión

function obtenerAdminPorId($id) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("SELECT * FROM admin WHERE Id = :id");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return null;
    } finally {
        $conexion = null;
    }
}


function actualizarAlumnos($matricula, $nombre, $apellido, $telefono, $correo, $grupo1, $semestre1 ){
    $conexion = conectarDB();
   
    try {
        // Utilizar sentencias preparadas para una mejor seguridad
        $sql = "UPDATE alumnos SET Matricula = :matricula, Nombre = :nombre, Apellido = :apell, Telefono = :tel, Correo = :email, Semestre = :semestre, Grupo = :grupo WHERE Matricula = :matricula1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apell', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':tel', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':email', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':semestre', $semestre1, PDO::PARAM_STR);
        $stmt->bindParam(':grupo', $grupo1, PDO::PARAM_STR);
        $stmt->bindParam(':matricula1', $matricula, PDO::PARAM_STR);

        // Ejecutar la consulta
        $qryExecute = $stmt->execute();

        if ($qryExecute) {
            header("refresh:1;url=IndexSecretarias.php");
            exit("Datos Actualizados. Redirigiendo en 1 segundos...");
        } else {
            $errorInfo = $stmt->errorInfo();
             // Registrar o mostrar detalles del error
            error_log("Fail: " . $errorInfo[2], 0);
            echo "Error al ejecutar la consulta de actualización: " . $errorInfo[2];
            exit();
        }
    } catch (PDOException $e) {
        // Manejar excepciones
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión



function eliminarProfesor($numEmp) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("DELETE FROM profesores WHERE NumEmp = :numEmp");
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);

        return $consulta->execute();
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        $conexion = null;
    }
}

function obtenerCiclosEscolares() {
    $conexion = conectarDB();

    try {
        $consultaCiclos = $conexion->prepare("SELECT DISTINCT Ciclo_Escolar FROM cursar");
        $consultaCiclos->execute();
        return $consultaCiclos;

function obtenerLaboratorioPorNumEmp($numEmp) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("SELECT
            p.NumEmp AS NumEmpProfesor,
            p.Nombre AS NombreProfesor,
            p.Apellidos AS ApellidosProfesor,
            l.NomLaboratorio AS Laboratorio,
            m.Clave AS ClaveMateria,
            m.Nombre AS NombreMateria
        FROM
            profesores p
        JOIN
            prof_lab pl ON p.NumEmp = pl.Num_Emp
        JOIN
            laboratorios l ON pl.IdLaboratorio = l.IdLaboratorios
        JOIN
            materias m ON l.IdLaboratorios = m.IdLaboratorio
        WHERE
            p.NumEmp = :numEmp");

        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);

        $consulta->execute();

        // Obtén los resultados de la consulta
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;

    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {

        // Cerrar la conexión

        $conexion = null;
    }
}


function mostrarInformacionAlumno($numero_matricula, $ciclo_escolar) {
    $conexion = conectarDB();

    try {
        // Consulta SQL con las variables
        $sql = "SELECT a.Matricula, a.Nombre, a.Apellido, a.Semestre, a.Grupo, m.Clave, m.Nombre as Materia, c.Calificacion, f.Nombre as Carrera 
                FROM alumnos a 
                INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno 
                INNER JOIN materias m ON c.Clave_Materia = m.Clave 
                INNER JOIN formacion f ON m.ClaveFormacion = f.Clave 
                WHERE a.Matricula = :matricula AND c.Ciclo_Escolar = :ciclo_escolar";

        $statement = $conexion->prepare($sql);
        $statement->bindParam(':matricula', $numero_matricula, PDO::PARAM_INT);
        $statement->bindParam(':ciclo_escolar', $ciclo_escolar, PDO::PARAM_STR);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($resultado) {
            // Obtener información del alumno
            $fila_alumno = $resultado[0];

            // Mostrar tabla 1 con información del alumno
            echo "<h2>Información del Alumno</h2>";
            echo "<table>";
            echo "<tr><th>Matrícula</th><td>{$fila_alumno['Matricula']}</td></tr>";
            echo "<tr><th>Nombre</th><td>{$fila_alumno['Nombre']} {$fila_alumno['Apellido']}</td></tr>";
            echo "<tr><th>Carrera</th><td>{$fila_alumno['Carrera']}</td></tr>";
            echo "<tr><th>Ciclo Escolar</th><td>{$ciclo_escolar}</td></tr>";
            echo "<tr><th>Semestre</th><td>{$fila_alumno['Semestre']}</td></tr>";
            echo "<tr><th>Grupo</th><td>{$fila_alumno['Grupo']}</td></tr>";
            echo "</table>";

            // Mostrar tabla 2 con información de materias y calificaciones
            echo "<h2>Calificaciones</h2>";
            echo "<table>";
            echo "<tr><th>Clave de Materia</th><th>Nombre de Materia</th><th>Calificación</th></tr>";

            // Mostrar información de cada materia
            foreach ($resultado as $fila_materia) {
                echo "<tr><td>{$fila_materia['Clave']}</td><td>{$fila_materia['Materia']}</td><td>{$fila_materia['Calificacion']}</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Sin coincidencias.</p>";
        }
    } catch (PDOException $e) {
        // Manejar la excepción aquí, si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos

// En funciones.php
function obtenerNombreProfesor($numEmp) {
    $conexion = conectarDB();

    try {
        $consulta = $conexion->prepare("SELECT Nombre FROM profesores WHERE NumEmp = :numEmp");
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_INT);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['Nombre'];
        } else {
            return "Nombre no encontrado";
        }
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        $conexion = null;
    }
}



?>



