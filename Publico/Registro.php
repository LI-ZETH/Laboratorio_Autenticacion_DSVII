<?php
session_start();
require_once __DIR__ . '/../Logica/Registro.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registro = new Registro();
    $mensaje = $registro->registrarUsuario(
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['usuario'],
        $_POST['correo'],
        $_POST['password'],
        $_POST['sexo']
    );

    if ($mensaje === "Usuario registrado correctamente.") {
        // Generar secreto y QR
        $usuarioLimpio = Sanitizacion::limpiarUsuario($_POST['usuario']);
        $auth = new Autenticacion();
        $qrUrl = $auth->generar2FA($usuarioLimpio);

        echo "<h2>Escanea este código QR en Google Authenticator</h2>";
        echo "<img src='$qrUrl'>";
        echo "<p>Después de escanear, ya puedes iniciar sesión con tu usuario y contraseña, seguido del código 2FA.</p>";
    } else {
        echo "<p>$mensaje</p>";
        echo "<p><a href='Registro.php'>Volver al registro</a></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
    <script src="../Assets/Validaciones.js"></script>
</head>
<body>
    <h2>Formulario de Registro</h2>

    <?php if (!empty($mensaje)): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label>Apellido:</label>
        <input type="text" name="apellido" required><br>

        <label>Usuario:</label>
        <input type="text" name="usuario" required><br>

        <label>Correo:</label>
        <input type="email" name="correo" required><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br>

        <label>Sexo:</label>
        <select name="sexo" required>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
            <option value="Otro">Otro</option>
        </select><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
