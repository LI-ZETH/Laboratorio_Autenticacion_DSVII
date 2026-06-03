<?php
session_start();
require_once __DIR__ . '/../Configuracion/DB.php';

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: Index.php");
    exit();
}

$db = new DB();
$conn = $db->conectar();

// Traer todos los usuarios
$stmt = $conn->query("SELECT nombre, apellido, usuario, correo, sexo FROM usuarios ORDER BY id ASC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablas de Usuarios</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
</head>
<body>
    <div class="panel visible">
        <h2>Tablas de Usuarios</h2>

        <!-- Primera tabla: nombre, apellido y correo -->
        <h3>Datos principales de los usuarios</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
            </tr>
            <?php foreach ($usuarios as $fila): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                <td><?php echo htmlspecialchars($fila['apellido']); ?></td>
                <td><?php echo htmlspecialchars($fila['correo']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Segunda tabla: usuario y género -->
        <h3>Usuarios y su género</h3>
        <table>
            <tr>
                <th>Usuario</th>
                <th>Sexo</th>
            </tr>
            <?php foreach ($usuarios as $fila): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                <td><?php echo htmlspecialchars($fila['sexo']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p><a href="Dashboard.php" class="btn">Volver al Dashboard</a></p>
    </div>
</body>
</html>
