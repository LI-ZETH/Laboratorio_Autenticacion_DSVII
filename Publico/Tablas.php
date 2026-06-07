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
$stmtUsuarios = $conn->query("SELECT nombre, apellido, correo FROM usuarios ORDER BY id ASC");
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

// Traer registros de acceso
$stmtAccesos = $conn->query("SELECT usuario, cantidad_ingresos FROM registros_acceso ORDER BY cantidad_ingresos DESC");
$accesos = $stmtAccesos->fetchAll(PDO::FETCH_ASSOC);
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

        <!-- Primera tabla: usuarios -->
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

        <!-- Segunda tabla: registros de acceso -->
        <h3>Cantidad de ingresos al sistema</h3>
        <table>
            <tr>
                <th>Usuario</th>
                <th>Cantidad de ingresos</th>
            </tr>
            <?php foreach ($accesos as $fila): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                <td><?php echo htmlspecialchars($fila['cantidad_ingresos']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p><a href="Dashboard.php" class="btn">Volver al Dashboard</a></p>
    </div>
</body>
</html>
