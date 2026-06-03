<?php
session_start();
require_once __DIR__ . '/../Logica/Registro.php';

$mensaje = "";
$qrUrl = "";
$showForm = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registro = new Registro();
    $mensaje = $registro->registrarUsuario(
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['usuario'],
        $_POST['correo'],
        $_POST['password'],
        $_POST['confirm_password'],
        $_POST['sexo']
    );

    if ($mensaje === "Usuario registrado correctamente.") {
        // Generar secreto y QR pero no imprimir inmediatamente; mostrar en la UI
        $usuarioLimpio = Sanitizacion::limpiarUsuario($_POST['usuario']);
        $auth = new Autenticacion();
        $qrUrl = $auth->generar2FA($usuarioLimpio);
        $showForm = false;
    } else {
        // Mantener mensaje para mostrar en la página
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../Assets/Estilos.css?v=3">
    <style>
        .qr-container {
            max-width: 420px;
            margin: 24px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            text-align: center;
        }

        .qr-container h2 {
            margin-top: 0;
        }

        .qr-container img {
            max-width: 300px;
            height: auto;
            display: block;
            margin: 12px auto;
        }

        .qr-actions {
            margin-top: 12px;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 6px;
            background: #2b6cb0;
            color: #fff;
            text-decoration: none;
        }
    </style>
    <script src="../Assets/Validaciones.js"></script>
</head>

<body>
    <h2>Formulario de Registro</h2>

    <?php if (!empty($mensaje)): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>

    <?php if (!empty($qrUrl)): ?>
        <div class="qr-container panel">
            <h2>Escanea este código QR</h2>
            <p>Agrega la cuenta en Google Authenticator para habilitar 2FA.</p>
            <img src="<?php echo htmlspecialchars($qrUrl); ?>" alt="Código QR 2FA">
            <div class="qr-actions">
                <a class="btn nav-animate" href="LogIn.php">Ir a inicio de sesión</a>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($showForm): ?>
        <form class="panel" method="POST" action="">
            <label>Nombre:</label>
            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>"><br>

            <label>Apellido:</label>
            <input type="text" name="apellido" required value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>"><br>

            <label>Usuario:</label>
            <input type="text" name="usuario" required value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>"><br>

            <label>Correo:</label>
            <input type="email" name="correo" required value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>"><br>

            <label>Contraseña:</label>
            <input type="password" name="password" required><br>

            <label>Confirmar Contraseña:</label>
            <input type="password" name="confirm_password" required><br>

            <label>Sexo:</label>
            <select name="sexo" required>
                <option value="M" <?php echo (isset($_POST['sexo']) && $_POST['sexo']=='M') ? 'selected' : ''; ?>>Masculino</option>
                <option value="F" <?php echo (isset($_POST['sexo']) && $_POST['sexo']=='F') ? 'selected' : ''; ?>>Femenino</option>
                <option value="Otro" <?php echo (isset($_POST['sexo']) && $_POST['sexo']=='Otro') ? 'selected' : ''; ?>>Otro</option>
            </select><br>

            <button type="submit">Registrar</button>
        </form>

    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // reveal panels with a small stagger
            document.querySelectorAll('.panel').forEach(function (p, i) {
                setTimeout(function () { p.classList.add('visible'); }, i * 60);
            });

            // animate navigation links that should show exit animation
            document.querySelectorAll('a.nav-animate').forEach(function (a) {
                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    var href = this.href;
                    document.querySelectorAll('.panel.visible').forEach(function (p) { p.classList.remove('visible'); p.classList.add('exit'); });
                    setTimeout(function () { window.location.href = href; }, 300);
                });
            });
        });
    </script>
</body>

</html>