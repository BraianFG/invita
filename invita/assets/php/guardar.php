<?php 
header('Content-Type: application/json');
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');


error_reporting(E_ALL);

$uploadDir = __DIR__ . '/../../invitaciones/img/';
$jsonDir = __DIR__ . '/../../invitaciones/json/';
$plantillasDir = $uploadDir . '../../invitaciones/img/modelos/';
$fuentePath = __DIR__ . '/../../fuentes/GreatVibes-Regular.ttf';

if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
if (!file_exists($jsonDir)) mkdir($jsonDir, 0755, true);

// Función para generar código aleatorio
function generarCodigo($length = 8) {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

// Validación básica
$modelo     = $_POST['modelo'] ?? '';
$evento     = trim($_POST['evento'] ?? '');
$nombre     = trim($_POST['nombre'] ?? '');
$mensaje    = trim($_POST['mensaje'] ?? '');
$fecha      = trim($_POST['fecha'] ?? '');
$hora       = trim($_POST['hora'] ?? '');
$direccion  = trim($_POST['direccion'] ?? '');

if (!$evento) {
    echo json_encode(['success' => false, 'message' => 'Debes ingresar el nombre del evento.']);
    exit;
}

if (!$nombre) {
    echo json_encode(['success' => false, 'message' => 'El nombre es obligatorio.']);
    exit;
}

// Validación opcional para campos adicionales
if (!$fecha) {
    echo json_encode(['success' => false, 'message' => 'La fecha es obligatoria.']);
    exit;
}

if (!$hora) {
    echo json_encode(['success' => false, 'message' => 'La hora es obligatoria.']);
    exit;
}

if (!$direccion) {
    echo json_encode(['success' => false, 'message' => 'La dirección es obligatoria.']);
    exit;
}



if (!$modelo || !$evento || !$nombre) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit;
}

// Validar imagen
if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
    exit;
}

$allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
$mime = $_FILES['imagen']['type'];
if (!isset($allowedTypes[$mime])) {
    echo json_encode(['success' => false, 'message' => 'Formato de imagen no permitido.']);
    exit;
}

$codigo = generarCodigo();
$ext = $allowedTypes[$mime];
$nombreImagen = 'foto_' . $codigo . '.' . $ext;
$rutaImagen = $uploadDir . $nombreImagen;

if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
    echo json_encode(['success' => false, 'message' => 'No se pudo guardar la imagen.']);
    exit;
}

$mensajeFinal = "¡Estás invitado al $evento de $nombre! 🎉 ";

if (!empty($mensaje)) {
    $mensajeFinal .= "$mensaje ";
}

if (!empty($fecha) && !empty($hora)) {
    $mensajeFinal .= "Será el día $fecha a las $hora. ";
} elseif (!empty($fecha)) {
    $mensajeFinal .= "Será el día $fecha. ";
} elseif (!empty($hora)) {
    $mensajeFinal .= "Será a las $hora. ";
}

if (!empty($direccion)) {
    $mensajeFinal .= "Te esperamos en $direccion.";
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

file_put_contents($jsonDir . $codigo . '.json', json_encode($datosInvitacion, JSON_PRETTY_PRINT));

// ============= GENERAR IMAGEN FINAL ============= //
$plantillaPath = $plantillasDir . $modelo . '.png';
if (!file_exists($plantillaPath)) {
    echo json_encode(['success' => false, 'message' => 'No se encontró la plantilla.']);
    exit;
}

$base = imagecreatefrompng($plantillaPath);
imagealphablending($base, true);
imagesavealpha($base, true);

// Cargar imagen del usuario
$userImg = imagecreatefromstring(file_get_contents($rutaImagen));
if (!$userImg) {
    echo json_encode(['success' => false, 'message' => 'No se pudo procesar la imagen subida.']);
    exit;
}

// Redimensionar imagen del usuario
$destW = 200;
$destH = 200;
$resized = imagecreatetruecolor($destW, $destH);
imagealphablending($resized, false);
imagesavealpha($resized, true);
imagecopyresampled($resized, $userImg, 0, 0, 0, 0, $destW, $destH, imagesx($userImg), imagesy($userImg));
imagecopy($base, $resized, 50, 50, 0, 0, $destW, $destH);

// Escribir texto
$negro = imagecolorallocate($base, 0, 0, 0);
if (file_exists($fuentePath)) {
    imagettftext($base, 30, 0, 300, 150, $negro, $fuentePath, $nombre);
    imagettftext($base, 20, 0, 300, 200, $negro, $fuentePath, $evento);
} else {
    imagestring($base, 5, 300, 150, $nombre, $negro);
    imagestring($base, 3, 300, 180, $evento, $negro);
}

// Guardar imagen final
$imagenFinal = 'inv_' . $codigo . '.png';
$outputPath = $uploadDir . $imagenFinal;
imagepng($base, $outputPath);
imagedestroy($base);
imagedestroy($userImg);
imagedestroy($resized);

// RESPUESTA OK
echo json_encode([
    'success' => true,
    'file' => $codigo // Redirige a ver_invitacion.php?file=XXXX
]);
exit;
