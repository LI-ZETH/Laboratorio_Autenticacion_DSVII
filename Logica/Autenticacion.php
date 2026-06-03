<?php
// Logica/Autenticacion.php
require_once __DIR__ . '/../Configuracion/DB.php';
require_once __DIR__ . '/Sanitizacion.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Para GoogleAuthenticator

use Google\Authenticator\GoogleAuthenticator;
use Google\Authenticator\GoogleQrUrl;

class Autenticacion {
    private $conn;
    private $ga;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->conectar();
        $this->ga = new GoogleAuthenticator();
    }

    // Iniciar sesión (usuario + contraseña)
    public function login($usuario, $password) {
        $usuario = Sanitizacion::limpiarUsuario($usuario);

        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "Usuario no encontrado.";
        }

        if (password_verify($password, $user['password'])) {
            // Guardamos temporalmente el usuario en sesión para validar 2FA
            $_SESSION['usuario_temp'] = $user['usuario'];
            $_SESSION['secret'] = $user['secret']; // Secreto 2FA guardado en BD
            return "Contraseña correcta. Ingrese su código 2FA.";
        } else {
            return "Contraseña incorrecta.";
        }
    }

    // Validar código 2FA
    public function validar2FA($codigo) {
        if (!isset($_SESSION['secret'])) {
            return "No hay sesión activa para validar.";
        }

        $secret = $_SESSION['secret'];
        $checkResult = $this->ga->checkCode($secret, $codigo, 2); // margen de 2 pasos

        if ($checkResult) {
            // Login exitoso
            $_SESSION['usuario'] = $_SESSION['usuario_temp'];
            unset($_SESSION['usuario_temp']);
            return "Autenticación exitosa. Bienvenido al sistema.";
        } else {
            return "Código 2FA inválido.";
        }
    }

    // Generar secreto y QR para un nuevo usuario
    public function generar2FA($usuario) {
        $secret = $this->ga->generateSecret();
        $qrCodeUrl = GoogleQrUrl::generate($usuario, $secret, 'LaboratorioDSVII');

        // Guardar secreto en BD
        $stmt = $this->conn->prepare("UPDATE usuarios SET secret = ? WHERE usuario = ?");
        $stmt->execute([$secret, $usuario]);

        return $qrCodeUrl;
    }
}
?>
