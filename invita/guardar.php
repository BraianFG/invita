<?php
// Encabezados
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Rutas de carpetas
$folder = __DIR__ . '/invitaciones';
$folderImg = $folder . '/img';

// Crear carpetas si no existen
if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}
if (!is_dir($folderImg)) {
    mkdir($folderImg, 0755, true);
}

// Solo aceptar método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validar campos
    if (
        isset($_POST['fecha'], $_POST['hora'], $_POST['direccion'], $_POST['evento'],
              $_POST['mensaje'], $_POST['nombre']) && isset($_FILES['imagen'])
    ) {
        $fecha     = $_POST['fecha'];
        $hora      = $_POST['hora'];
        $direccion = $_POST['direccion'];
        $evento    = $_POST['evento'];
        $mensaje   = $_POST['mensaje'];
        $nombre    = $_POST['nombre'];
        $imagen    = $_FILES['imagen'];

        // Validar imagen subida
        if ($imagen['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al subir la imagen.']);
            exit;
        }

        // Validar extensión
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $nombreOriginal = $imagen['name'];
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

        if (!in_array($extension, $extensionesPermitidas)) {
            http_response_code(400);
            echo json_encode(['estado' => 'error', 'mensaje' => 'Formato de imagen no permitido.']);
            exit;
        }

        // Generar código único
        $codigo = bin2hex(random_bytes(8));
        $nombreImagen = $codigo . '.' . $extension;
        $rutaImagen = $folderImg . '/' . $nombreImagen;

        // Mover imagen
        if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            http_response_code(500);
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se pudo guardar la imagen.']);
            exit;
        }

        // Obtener día en español
        $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
        $diaSemanaNombre = $dias[(int)$fechaObj->format('w')];

        // Guardar JSON
        $entrada = [
            'fecha'      => $fecha,
            'hora'       => $hora,
            'direccion'  => $direccion,
            'evento'     => $evento,
            'mensaje'    => $mensaje,
            'nombre'     => $nombre,
            'imagen'     => 'img/' . $nombreImagen,
            'codigo'     => $codigo,
            'dia_semana' => $diaSemanaNombre,
            'timestamp'  => date('Y-m-d H:i:s')
        ];

        $archivoJson = $folder . '/' . $codigo . '.json';
        if (!file_put_contents($archivoJson, json_encode($entrada, JSON_PRETTY_PRINT))) {
            http_response_code(500);
            echo json_encode(['estado' => 'error', 'mensaje' => 'No se pudo guardar el JSON.']);
            exit;
        }

        // Todo correcto
        echo json_encode([
            'estado'      => 'ok',
            'mensaje'     => 'Datos guardados correctamente.',
            'codigo'      => $codigo,
            'dia_semana'  => $diaSemanaNombre
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['estado' => 'error', 'mensaje' => 'Faltan datos o imagen.']);
    }

} else {
    http_response_code(405);
    echo json_encode(['estado' => 'error', 'mensaje' => 'Método no permitido.']);
}
?>
