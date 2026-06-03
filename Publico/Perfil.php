<?php
session_start();
require_once __DIR__ . '/../Configuracion/DB.php';

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: Index.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Conectar a la base de datos
$db = new DB();
$conn = $db->conectar();

// Consultar datos del usuario
$stmt = $conn->prepare("SELECT nombre, apellido, usuario, correo, sexo FROM usuarios WHERE usuario = ?");
$stmt->execute([$usuario]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$datos) {
    echo "No se encontraron datos del usuario.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
</head>
<body>
    <h2>Este es tu perfil</h2>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($datos['nombre']); ?></p>
    <p><strong>Apellido:</strong> <?php echo htmlspecialchars($datos['apellido']); ?></p>
    <p><strong>Usuario:</strong> <?php echo htmlspecialchars($datos['usuario']); ?></p>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($datos['correo']); ?></p>
    <p><strong>Sexo:</strong> <?php echo htmlspecialchars($datos['sexo']); ?></p>

    <p><a href="Dashboard.php">Volver al Dashboard</a></p>
</body>
</html>
