<?php

function conectarDB() {
    // Detalles de conexión
    $host = 'localhost';
    $usuario = 'root';
    $password = '';
    $dbname = 'mybd';

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



?>