<?php
try {
    // Conexión con root para crear la base
    $pdo = new PDO("mysql:host=localhost", "root", "NochuMochi13");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear base si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS laboratorio_autenticacion");
    $pdo->exec("USE laboratorio_autenticacion");

    // Crear tabla si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        apellido VARCHAR(50) NOT NULL,
        usuario VARCHAR(50) UNIQUE NOT NULL,
        correo VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        sexo ENUM('M','F') NOT NULL,
        secret VARCHAR(32) DEFAULT NULL
    )");

    echo "Base de datos y tabla creadas correctamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
