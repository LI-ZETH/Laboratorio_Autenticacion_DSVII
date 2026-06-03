<?php
session_start();
require_once __DIR__ . '/../Logica/Autenticacion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Autenticacion();
    $mensaje = $auth->login($_POST['usuario'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Laboratorio Autenticación</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
</head>
<body>
    <h2>Inicio de Sesión</h2>

    <?php if (!empty($mensaje)): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php if ($mensaje === "Contraseña correcta. Ingrese su código 2FA."): ?>
            <form method="POST" action="Validar_2FA.php">
                <label>Código 2FA:</label>
                <input type="text" name="codigo" required>
                <button type="submit">Validar</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Ingresar</button>
    </form>

    <p>¿No tienes cuenta? <a href="Registro.php">Regístrate aquí</a></p>
</body>
</html>
