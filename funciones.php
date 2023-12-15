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
        $conexion = null;
    }
}

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

