<?php

$servidor = "localhost";
$usuario = "root";
$clave = "";
$baseDatos = "incidencias_db";

try {
    $conexion = new PDO(
        "mysql:host=$servidor;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $clave
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    http_response_code(500);
    exit("Error de conexión con la base de datos.");
}

?>