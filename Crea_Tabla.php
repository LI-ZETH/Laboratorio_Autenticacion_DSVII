<?php
try {
    // Conexión con root
    $pdo = new PDO("mysql:host=localhost", "root", "NochuMochi13");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Borrar base de datos si existe
    $pdo->exec("DROP DATABASE IF EXISTS laboratorio_autenticacion");

    // Crear base de datos nuevamente
    $pdo->exec("CREATE DATABASE laboratorio_autenticacion");
    $pdo->exec("USE laboratorio_autenticacion");

    // Crear tabla usuarios
    $pdo->exec("CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        apellido VARCHAR(50) NOT NULL,
        usuario VARCHAR(50) UNIQUE NOT NULL,
        correo VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        sexo ENUM('M','F') NOT NULL,
        secret VARCHAR(32) DEFAULT NULL
    )");

    // Crear tabla registros_acceso con usuario único
    $pdo->exec("CREATE TABLE registros_acceso (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(50) NOT NULL UNIQUE,
        cantidad_ingresos INT DEFAULT 0
    )");

    echo "Base de datos y tablas creadas correctamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
