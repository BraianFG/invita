<?php 
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$uploadDir = __DIR__ . '/../../invitaciones/img/';
$jsonDir = __DIR__ . '/../../invitaciones/json/';
$plantillasDir = $uploadDir . '../../invitaciones/img/modelos/';
$fuentePath = __DIR__ . '/../../fuentes/GreatVibes-Regular.ttf';

if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
if (!file_exists($jsonDir)) mkdir($jsonDir, 0755, true);

function generarCodigo($length = 8) {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

$modelo     = $_POST['modelo'] ?? '';
$evento     = trim($_POST['evento'] ?? '');
$nombre     = trim($_POST['nombre'] ?? '');
$mensaje    = trim($_POST['mensaje'] ?? '');
$fecha      = trim($_POST['fecha'] ?? '');
$hora       = trim($_POST['hora'] ?? '');
$direccion  = trim($_POST['direccion'] ?? '');

if (!$evento) exit(json_encode(['success' => false, 'message' => 'Debes ingresar el nombre del evento.']));
if (!$nombre) exit(json_encode(['success' => false, 'message' => 'El nombre es obligatorio.']));
if (!$fecha) exit(json_encode(['success' => false, 'message' => 'La fecha es obligatoria.']));
if (!$hora) exit(json_encode(['success' => false, 'message' => 'La hora es obligatoria.']));
if (!$direccion) exit(json_encode(['success' => false, 'message' => 'La dirección es obligatoria.']));
if (!$modelo || !$evento || !$nombre) exit(json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']));

if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    exit(json_encode(['success' => false, 'message' => 'Error al subir la imagen.']));
}

$allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
$mime = $_FILES['imagen']['type'];
if (!isset($allowedTypes[$mime])) {
    exit(json_encode(['success' => false, 'message' => 'Formato de imagen no permitido.']));
}

$codigo = generarCodigo();
$ext = $allowedTypes[$mime];
$nombreImagen = 'foto_' . $codigo . '.' . $ext;
$rutaImagen = $uploadDir . $nombreImagen;

if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
    exit(json_encode(['success' => false, 'message' => 'No se pudo guardar la imagen.']));
}

// Crear JSON
$datosInvitacion = [
    'success' => true,
    'codigo' => $codigo,
    'modelo' => $modelo,
    'evento' => $evento,
    'nombre' => $nombre,
    'imagen' => $nombreImagen,
    'mensaje' => $mensaje,
    'fecha' => $fecha,
    'hora' => $hora,
    'direccion' => $direccion,
    'fecha_creacion' => date('Y-m-d H:i:s')
];

file_put_contents($jsonDir . $codigo . '.json', json_encode($datosInvitacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// ============= GENERAR IMAGEN FINAL ============= //
$plantillaPath = $plantillasDir . $modelo . '.png';
if (!file_exists($plantillaPath)) {
    exit(json_encode(['success' => false, 'message' => 'No se encontró la plantilla.']));
}

$base = imagecreatefrompng($plantillaPath);
imagealphablending($base, true);
imagesavealpha($base, true);

$userImg = imagecreatefromstring(file_get_contents($rutaImagen));
if (!$userImg) {
    exit(json_encode(['success' => false, 'message' => 'No se pudo procesar la imagen subida.']));
}

$destW = 200;
$destH = 200;
$resized = imagecreatetruecolor($destW, $destH);
imagealphablending($resized, false);
imagesavealpha($resized, true);
imagecopyresampled($resized, $userImg, 0, 0, 0, 0, $destW, $destH, imagesx($userImg), imagesy($userImg));
imagecopy($base, $resized, 50, 50, 0, 0, $destW, $destH);

$negro = imagecolorallocate($base, 0, 0, 0);

// Mensaje natural
// Traducción manual de días y meses
function traducirFecha($fechaYmd) {
    $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    $meses = [
        '01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril',
        '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto',
        '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'
    ];

    $timestamp = strtotime($fechaYmd);
    if (!$timestamp) return $fechaYmd;

    $diaSemana = $dias[date('w', $timestamp)];
    $diaMes = date('j', $timestamp);
    $mesNombre = $meses[date('m', $timestamp)];

    return ucfirst("$diaSemana $diaMes de $mesNombre");
}

// Generar mensaje natural
$fechaBonita = traducirFecha($fecha);
$mensajeFinal = "Te invitamos al $evento de $nombre.\n";

if ($fechaBonita && $hora) {
    $mensajeFinal .= "Será el $fechaBonita a las $hora hs.\n";
} elseif ($fechaBonita) {
    $mensajeFinal .= "Será el $fechaBonita.\n";
} elseif ($hora) {
    $mensajeFinal .= "Será a las $hora hs.\n";
}

if ($direccion) {
    $mensajeFinal .= "En $direccion.\n";
}

if ($mensaje) {
    $mensajeFinal .= "$mensaje 🎉";
}

// Mostrar nombre y evento
if (file_exists($fuentePath)) {
    imagettftext($base, 30, 0, 300, 150, $negro, $fuentePath, $nombre);
    imagettftext($base, 20, 0, 300, 200, $negro, $fuentePath, $evento);
} else {
    imagestring($base, 5, 300, 150, $nombre, $negro);
    imagestring($base, 3, 300, 180, $evento, $negro);
}

// Mostrar mensaje natural (multilínea)
$fontSize = 16;
$maxWidth = imagesx($base) - 100;
$lineHeight = 30;
$startX = 50;
$startY = 300;

if (file_exists($fuentePath)) {
    $words = explode(' ', $mensajeFinal);
    $line = '';
    $lines = [];
    foreach ($words as $word) {
        $testLine = $line . ' ' . $word;
        $bbox = imagettfbbox($fontSize, 0, $fuentePath, $testLine);
        $lineWidth = $bbox[2] - $bbox[0];
        if ($lineWidth < $maxWidth) {
            $line = $testLine;
        } else {
            $lines[] = trim($line);
            $line = $word;
        }
    }
    if ($line) $lines[] = trim($line);

    foreach ($lines as $i => $txt) {
        $bbox = imagettfbbox($fontSize, 0, $fuentePath, $txt);
        $textWidth = $bbox[2] - $bbox[0];
        $x = ($maxWidth - $textWidth) / 2 + $startX;
        $y = $startY + $i * $lineHeight;
        imagettftext($base, $fontSize, 0, $x, $y, $negro, $fuentePath, $txt);
    }
} else {
    imagestring($base, 3, $startX, $startY, $mensajeFinal, $negro);
}

$imagenFinal = 'inv_' . $codigo . '.png';
$outputPath = $uploadDir . $imagenFinal;
imagepng($base, $outputPath);
imagedestroy($base);
imagedestroy($userImg);
imagedestroy($resized);

echo json_encode([
    'success' => true,
    'file' => $codigo
]);
exit;
