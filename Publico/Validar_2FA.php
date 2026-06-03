<?php
session_start();
require_once __DIR__ . '/../Logica/Autenticacion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Autenticacion();
    $mensaje = $auth->validar2FA($_POST['codigo']);

    if ($mensaje === "Autenticación exitosa. Bienvenido al sistema.") {
        // Redirigir al dashboard
        header("Location: Dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar 2FA</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
</head>
<body>
    <h2>Validación de Segundo Factor</h2>

    <?php if (!empty($mensaje)): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Código 2FA:</label>
        <input type="text" name="codigo" required>
        <button type="submit">Validar</button>
    </form>
</body>
</html>
