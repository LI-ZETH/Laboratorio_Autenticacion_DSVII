<?php
session_start();

// Verificar que el usuario haya pasado login + 2FA
if (!isset($_SESSION['usuario'])) {
    header("Location: Index.php");
    exit();
}

$usuario = htmlspecialchars($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
</head>
<body>
    <div class="panel visible">
        <h2>Bienvenido al Dashboard</h2>
        <p>Hola, <?php echo $usuario; ?>. Has iniciado sesión correctamente con 2FA.</p>

        <nav>
            <ul>
                <li><a href="Perfil.php" class="btn">Perfil</a></li>
                <li><a href="Tablas.php" class="btn">Tablas</a></li>
                <li><a href="CerrarSesion.php" class="btn">Cerrar Sesión</a></li>
            </ul>
        </nav>

        <p>Este es tu espacio seguro dentro del sistema.</p>
    </div>
</body>
</html>
