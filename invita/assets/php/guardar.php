<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Carpeta para guardar imágenes
$uploadDir = __DIR__ . '/../../invitaciones/img/';
$jsonDir = __DIR__ . '/../../invitaciones/json/';

// Crear carpetas si no existen
if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
if (!file_exists($jsonDir)) mkdir($jsonDir, 0755, true);

// Función para generar código aleatorio
function generarCodigo($length = 8) {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

// Validar campos
$modelo = $_POST['modelo'] ?? '';
$evento = trim($_POST['evento'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');

if (!$modelo) {
    echo json_encode(['success' => false, 'message' => 'No se seleccionó ningún modelo.']);
    exit;
}
if (!$evento) {
    echo json_encode(['success' => false, 'message' => 'No se especificó el evento.']);
    exit;
}
if (!$nombre) {
    echo json_encode(['success' => false, 'message' => 'El nombre es obligatorio.']);
    exit;
}

// Validar imagen
if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
    exit;
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['imagen']['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Formato de imagen no permitido.']);
    exit;
}

// Guardar imagen
$ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
$codigo = generarCodigo();
$nombreImagen = 'inv_' . $codigo . '.' . $ext;
$rutaImagen = $uploadDir . $nombreImagen;

if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
    echo json_encode(['success' => false, 'message' => 'No se pudo guardar la imagen.']);
    exit;
}

// Crear archivo JSON con datos de la invitación
$datosInvitacion = [
    'codigo' => $codigo,
    'modelo' => $modelo,
    'evento' => $evento,
    'nombre' => $nombre,
    'imagen' => $nombreImagen,
    'fecha_creacion' => date('Y-m-d H:i:s')
];

$jsonFile = $jsonDir . $codigo . '.json';
if (!file_put_contents($jsonFile, json_encode($datosInvitacion, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => false, 'message' => 'No se pudo guardar el archivo de datos.']);
    exit;
}

// Respuesta final
echo json_encode([
    'success' => true,
    'file' => $codigo, // Esto lo usás en ver_invitaciones.php
]);
exit;
