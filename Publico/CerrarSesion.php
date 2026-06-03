<?php
session_start();

// Guardar el nombre del usuario antes de destruir la sesión
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : "Usuario";

// Eliminar variables de sesión y destruir la sesión
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gracias</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
</head>
<body>
    <div class="panel visible">
        <h2>Gracias por inscribirse</h2>
        <p>Hasta pronto, <?php echo htmlspecialchars($usuario); ?>. ¡Vuelva pronto!</p>
        <p><a href="Index.php" class="btn">Volver al inicio</a></p>
    </div>
</body>
</html>
