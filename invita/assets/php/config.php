<?php
// config.php - Configuración base para guardar.php

// URL base de la aplicación (ajustar según tu dominio/ruta)
define('APP_URL', 'http://braianfg.com.ar/invita/');  // Cambia por tu URL real

// Tamaño máximo permitido para la imagen (10 MB en bytes)
define('MAX_FILE_SIZE', 10 * 1024 * 1024);

// Extensiones permitidas para la imagen
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Modo debug para mostrar logs o errores (true o false)
define('DEBUG_MODE', true);

/**
 * Sanitiza la entrada para evitar XSS y espacios extra
 */
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Genera un código único aleatorio (hexadecimal)
 * Puedes cambiar la lógica para adaptarla
 */
function generate_unique_code($length = 8) {
    // $length debe ser par para bin2hex
    if ($length % 2 !== 0) $length++;
    return bin2hex(random_bytes($length / 2));
}

header('Content-Type: application/json; charset=utf-8');