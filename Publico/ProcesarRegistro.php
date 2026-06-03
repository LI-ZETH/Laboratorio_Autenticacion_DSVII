<?php
session_start();
require_once __DIR__ . '/../Logica/Registro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registro = new Registro();
    $resultado = $registro->registrarUsuario(
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['usuario'],
        $_POST['correo'],
        $_POST['password'],
        $_POST['sexo']
    );

    // Mostrar mensaje y redirigir
    if ($resultado === "Usuario registrado correctamente.") {
        echo "<p>$resultado</p>";
        echo "<p><a href='Index.php'>Ir al Login</a></p>";
    } else {
        echo "<p>Error: $resultado</p>";
        echo "<p><a href='Registro.php'>Volver al Registro</a></p>";
    }
} else {
    header("Location: Registro.php");
    exit();
}
?>
