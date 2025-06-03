<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Recibir código por GET
$codigo = $_GET['codigo'] ?? '';
if (!preg_match('/^[A-Z0-9]{6,12}$/', $codigo)) {
    http_response_code(400);
    die('Código inválido.');
}

// Rutas importantes
$jsonPath = __DIR__ . '/../../invitaciones/json/' . $codigo . '.json';
$plantillasDir = __DIR__ . '/../../invitaciones/img/modelos/';
$uploadDir = __DIR__ . '/../../invitaciones/imh/';
$outputDir = __DIR__ . '/../../invitaciones/img/';

// Verificar que exista JSON con datos
if (!file_exists($jsonPath)) {
    http_response_code(404);
    die('Datos no encontrados.');
}

// Cargar datos
$data = json_decode(file_get_contents($jsonPath), true);
$modelo = $data['modelo'] ?? null;
$nombre = $data['nombre'] ?? null;
$evento = $data['evento'] ?? null;
$imagenUsuario = $data['imagen'] ?? null;

if (!$modelo || !$nombre || !$evento || !$imagenUsuario) {
    die('Faltan datos obligatorios en JSON.');
}

// Cargar plantilla base (intenta png, luego jpg)
$plantillaPathPng = $plantillasDir . $modelo . '.png';
$plantillaPathJpg = $plantillasDir . $modelo . '.jpg';

if (file_exists($plantillaPathPng)) {
    $base = imagecreatefrompng($plantillaPathPng);
} elseif (file_exists($plantillaPathJpg)) {
    $base = imagecreatefromjpeg($plantillaPathJpg);
} else {
    die("No existe la plantilla para el modelo: $modelo");
}

if (!$base) {
    die('No se pudo cargar la plantilla base.');
}

// Cargar imagen usuario
$imagenUsuarioPath = $uploadDir . $imagenUsuario;
if (!file_exists($imagenUsuarioPath)) {
    die('No se encontró la imagen del usuario.');
}
$userImgRaw = file_get_contents($imagenUsuarioPath);
$userImg = @imagecreatefromstring($userImgRaw);
if (!$userImg) {
    die('No se pudo cargar la imagen del usuario.');
}

// Redimensionar imagen usuario para encajar en la plantilla
$anchoDestino = 200;  // Ajustar según plantilla
$altoDestino = 200;   // Ajustar según plantilla
$xDestino = 50;       // Posición X en la plantilla
$yDestino = 50;       // Posición Y en la plantilla

$resizedUserImg = imagecreatetruecolor($anchoDestino, $altoDestino);
imagealphablending($resizedUserImg, false);
imagesavealpha($resizedUserImg, true);
imagecopyresampled(
    $resizedUserImg,
    $userImg,
    0, 0, 0, 0,
    $anchoDestino, $altoDestino,
    imagesx($userImg), imagesy($userImg)
);
imagedestroy($userImg);

// Combinar imagen usuario sobre plantilla
imagealphablending($base, true);
imagesavealpha($base, true);
imagecopy($base, $resizedUserImg, $xDestino, $yDestino, 0, 0, $anchoDestino, $altoDestino);
imagedestroy($resizedUserImg);

// Colores y fuente para texto
$colorTexto = imagecolorallocate($base, 0, 0, 0);
$fuentePath = __DIR__ . '/../../fuentes/GreatVibes-Regular.ttf'; // Asegúrate que la fuente exista

// Agregar texto (nombre y evento) a la plantilla
if (file_exists($fuentePath)) {
    imagettftext($base, 30, 0, 300, 150, $colorTexto, $fuentePath, $nombre);
    imagettftext($base, 20, 0, 300, 200, $colorTexto, $fuentePath, $evento);
} else {
    // fallback si no hay fuente TTF
    imagestring($base, 5, 300, 150, $nombre, $colorTexto);
    imagestring($base, 3, 300, 180, $evento, $colorTexto);
}

// Guardar imagen final combinada (formato PNG para conservar transparencia)
$outputPath = $outputDir . 'inv_' . $codigo . '.png';
if (!imagepng($base, $outputPath)) {
    imagedestroy($base);
    die('Error guardando la imagen final.');
}
imagedestroy($base);

// Redirigir para mostrar invitación generada
header("Location: ver_invitaciones.php?file=inv_$codigo.png");
exit;
