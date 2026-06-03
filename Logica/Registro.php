<?php
// Logica/Registro.php
require_once __DIR__ . '/../Configuracion/DB.php';
require_once __DIR__ . '/Sanitizacion.php';
require_once __DIR__ . '/../Logica/Autenticacion.php';

class Registro {
    private $conn;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->conectar();
    }

    // Registrar un nuevo usuario
    public function registrarUsuario($nombre, $apellido, $usuario, $correo, $password, $sexo) {
        // Sanitización
        $nombre   = Sanitizacion::limpiarTexto($nombre);
        $apellido = Sanitizacion::limpiarTexto($apellido);
        $usuario  = Sanitizacion::limpiarUsuario($usuario);
        if (empty($usuario)) {
            return "Usuario inválido. Use solo letras, números y guiones bajos.";
        }
        $correo   = Sanitizacion::limpiarEmail($correo);
        $sexo     = Sanitizacion::validarSexo($sexo);

        if (!$correo || !$sexo) {
            return "Datos inválidos (correo o sexo).";
        }

        // Validar duplicados
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE correo = ? OR usuario = ?");
        $stmt->execute([$correo, $usuario]);
        if ($stmt->rowCount() > 0) {
            return "El correo o usuario ya existe.";
        }

        // Hashear contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en BD
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, apellido, usuario, correo, password, sexo) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nombre, $apellido, $usuario, $correo, $hash, $sexo])) {
            return "Usuario registrado correctamente.";
        } else {
            return "Error al registrar usuario.";
        }
    }
}
?>
