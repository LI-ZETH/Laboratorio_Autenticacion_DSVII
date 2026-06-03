<?php
session_start();
require_once __DIR__ . '/../Logica/Autenticacion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Autenticacion();
    $resultado = $auth->login($_POST['usuario'], $_POST['password']);

    if ($resultado === "Contraseña correcta. Ingrese su código 2FA.") {
        // Mostrar formulario para ingresar el código 2FA
        echo "<h2>Validación 2FA</h2>";
        echo "<form method='POST' action='Validar_2FA.php'>
                <label>Código 2FA:</label>
                <input type='text' name='codigo' required>
                <button type='submit'>Validar</button>
              </form>";
    } else {
        echo "<p>$resultado</p>";
        echo "<p><a href='Index.php'>Volver al Login</a></p>";
    }
} else {
    header("Location: Index.php");
    exit();
}
?>
