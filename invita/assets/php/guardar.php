<?php
// guardar.php - Versión mejorada
require_once 'config.php';

// Encabezados CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Función para enviar respuesta JSON y terminar
function send_response($status, $message, $data = []) {
    http_response_code($status);
    $response = array_merge(['estado' => ($status === 200) ? 'ok' : 'error', 'mensaje' => $message], $data);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

// Solo aceptar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_response(405, 'Método no permitido. Solo se acepta POST.');
}

// Definir rutas de carpetas
$invitacionesDir = __DIR__ . '/../../invitaciones';
$imagenesDir = $invitacionesDir . '/img';

// Crear carpetas si no existen
foreach ([$invitacionesDir, $imagenesDir] as $dir) {
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true)) {
            send_response(500, 'Error al crear directorio necesario.');
        }
    }
}


// Validar que todos los campos requeridos están presentes
$camposRequeridos = ['fecha', 'hora', 'direccion', 'evento', 'mensaje', 'nombre'];
$datosFaltantes = [];

foreach ($camposRequeridos as $campo) {
    if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
        $datosFaltantes[] = $campo;
    }
}

if (!empty($datosFaltantes)) {
    send_response(400, 'Faltan los siguientes campos: ' . implode(', ', $datosFaltantes));
}

// Validar que se subió una imagen
if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    $errorMsg = 'Error al subir la imagen';
    if (isset($_FILES['imagen']['error'])) {
        switch ($_FILES['imagen']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errorMsg = 'La imagen es demasiado grande. Máximo ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB';
                break;
            case UPLOAD_ERR_NO_FILE:
                $errorMsg = 'No se seleccionó ninguna imagen';
                break;
        }
    }
    send_response(400, $errorMsg);
}

// Limpiar y validar datos de entrada
$fecha = sanitize_input($_POST['fecha']);
$hora = sanitize_input($_POST['hora']);
$direccion = sanitize_input($_POST['direccion']);
$evento = sanitize_input($_POST['evento']);
$mensaje = sanitize_input($_POST['mensaje']);
$nombre = sanitize_input($_POST['nombre']);

if (!DateTime::createFromFormat('Y-m-d', $fecha)) {
    send_response(400, 'Formato de fecha inválido. Use YYYY-MM-DD');
}

// Validar formato de hora
if (!DateTime::createFromFormat('H:i', $hora)) {
    send_response(400, 'Formato de hora inválido. Use HH:MM');
}

// Validar que la fecha no sea del pasado
$fechaEvento = DateTime::createFromFormat('Y-m-d', $fecha);
if ($fechaEvento < new DateTime('today')) {
    send_response(400, 'La fecha del evento no puede ser en el pasado');
}

// Procesar imagen
$imagen = $_FILES['imagen'];
$nombreOriginal = $imagen['name'];
$extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

// Validar extensión de imagen
if (!in_array($extension, ALLOWED_EXTENSIONS)) {
    send_response(400, 'Formato de imagen no permitido. Use: ' . implode(', ', ALLOWED_EXTENSIONS));
}

// Validar tamaño de imagen
if ($imagen['size'] > MAX_FILE_SIZE) {
    send_response(400, 'La imagen es demasiado grande. Máximo ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB');
}

// Validar que es realmente una imagen
$infoImagen = getimagesize($imagen['tmp_name']);
if ($infoImagen === false) {
    send_response(400, 'El archivo no es una imagen válida');
}

// Generar código único y verificar que no existe
do {
    $codigo = generate_unique_code();
    $archivoJson = $invitacionesDir . '/' . $codigo . '.json';
} while (file_exists($archivoJson));

// Generar nombre único para la imagen
$nombreImagen = $codigo . '.' . $extension;
$rutaImagen = $imagenesDir . '/' . $nombreImagen;

// Mover imagen al directorio final
if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
    send_response(500, 'No se pudo guardar la imagen en el servidor');
}

// Obtener día de la semana en español
$diasSemana = [
    'Sunday' => 'Domingo',
    'Monday' => 'Lunes', 
    'Tuesday' => 'Martes',
    'Wednesday' => 'Miércoles',
    'Thursday' => 'Jueves',
    'Friday' => 'Viernes',
    'Saturday' => 'Sábado'
];

$fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
$diaIngles = $fechaObj->format('l');
$diaEspanol = $diasSemana[$diaIngles];

// Preparar datos para guardar
$datosInvitacion = [
    'codigo' => $codigo,
    'fecha' => $fecha,
    'hora' => $hora,
    'direccion' => $direccion,
    'evento' => $evento,
    'mensaje' => $mensaje,
    'nombre' => $nombre,
    'imagen' => 'img/' . $nombreImagen,
    'dia_semana' => $diaEspanol,
    'fecha_formateada' => $fechaObj->format('d/m/Y'),
    'timestamp_creacion' => date('Y-m-d H:i:s'),
    'ip_cliente' => $_SERVER['REMOTE_ADDR'] ?? 'desconocida',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido'
];

// Guardar archivo JSON
$jsonContent = json_encode($datosInvitacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
if (!file_put_contents($archivoJson, $jsonContent, LOCK_EX)) {
    // Si falla el guardado, eliminar la imagen
    if (file_exists($rutaImagen)) {
        unlink($rutaImagen);
    }
    send_response(500, 'No se pudieron guardar los datos de la invitación');
}

// Log de éxito (opcional, para estadísticas)
if (DEBUG_MODE) {
    error_log("Nueva invitación creada: {$codigo} - {$evento} - {$fecha}");
}

// Respuesta exitosa
send_response(200, 'Invitación creada exitosamente', [
    'codigo' => $codigo,
    'dia_semana' => $diaEspanol,
    'fecha_formateada' => $datosInvitacion['fecha_formateada'],
    'url_invitacion' => APP_URL . 'ver_invitacion.php?codigo=' . $codigo
]);
?>
