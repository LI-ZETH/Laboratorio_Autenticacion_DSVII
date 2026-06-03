<?php
// Logica/Sanitizacion.php
// Clase para sanitizar y validar datos de entrada

class Sanitizacion {

    // Limpia texto general (nombre, apellido, usuario)
    public static function limpiarTexto($dato) {
        // Elimina etiquetas HTML y espacios innecesarios
        $dato = strip_tags(trim($dato));
        $dato = preg_replace("/[^a-zA-Z0-9_]/", "", $dato);
        $dato = preg_replace('/#\w+\s*/', '', $dato); // Elimina hashtags
        $dato = preg_replace('/[%()]/', '', $dato); 
        // Convierte caracteres especiales en entidades HTML seguras
        return htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    }

    // Limpia y valida correos electrónicos
    public static function limpiarEmail($email) {
        // Sanitiza el correo
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        // Valida formato correcto
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return $email;
    }

    // Limpia nombres de usuario (solo letras, números y guiones bajos)
    public static function limpiarUsuario($usuario) {
        $usuario = trim($usuario);
        $usuario = preg_replace("/[^a-zA-Z0-9_]/", "", $usuario);
        $usuario = preg_replace('/#\w+\s*/', '', $usuario); // Elimina hashtags
        $usuario = preg_replace('/[%()]/', '', $usuario); 
        return $usuario;
    }

    // Valida sexo (solo valores permitidos)
    public static function validarSexo($sexo) {
        $permitidos = ["M", "F", "Otro"];
        return in_array($sexo, $permitidos) ? $sexo : false;
    }

    // Valida secreto 2FA (alfanumérico base32)
    public static function validarSecreto($secret) {
        return preg_match('/^[A-Z2-7=]+$/', $secret) ? $secret : false;
    }
}
?>
