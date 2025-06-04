<?php
// Configuración
$directorioJSON = '../../invitaciones/json/';
$directorioIMG  = '../../invitaciones/img/';

// Crear directorios si no existen
if (!is_dir($directorioJSON)) mkdir($directorioJSON, 0755, true);
if (!is_dir($directorioIMG)) mkdir($directorioIMG, 0755, true);

// Validar datos
$campos = ['nombre', 'fecha', 'hora', 'direccion', 'evento', 'mensaje', 'modelo'];
foreach ($campos as $campo) {
    if (empty($_POST[$campo])) {
        http_response_code(400);
        echo "Falta el campo: $campo";
        exit;
    }
}

// Nombre del archivo
$codigo = uniqid();
$imagenFinal = '';

// Subir imagen
$tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $tipoArchivo = $_FILES['imagen']['type'];
    if (!in_array($tipoArchivo, $tiposPermitidos)) {
        http_response_code(400);
        echo "Tipo de archivo no permitido. Solo se permiten imágenes JPEG, PNG o GIF.";
        exit;
    }

    $tmp  = $_FILES['imagen']['tmp_name'];
    $ext  = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $nombreArchivo = $codigo . '.' . strtolower($ext);
    $destino = $directorioIMG . $nombreArchivo;

    if (!move_uploaded_file($tmp, $destino)) {
        http_response_code(500);
        echo "Error al mover la imagen al directorio $destino.";
        exit;
    }
    $imagenFinal = $nombreArchivo;

    // Verificar que el archivo se haya guardado
    if (!file_exists($destino)) {
        http_response_code(500);
        echo "La imagen no se encuentra en el servidor: $destino";
        exit;
    }
} else {
    http_response_code(400);
    echo "Error en la carga de la imagen. Código de error: " . ($_FILES['imagen']['error'] ?? 'Desconocido');
    exit;
}

// Obtener tipo de evento final
$evento = $_POST['evento'] === 'otro' ? $_POST['otroEvento'] : $_POST['evento'];

// Guardar JSON
$datos = [
    'codigo'    => $codigo,
    'nombre'    => $_POST['nombre'],
    'fecha'     => $_POST['fecha'],
    'hora'      => $_POST['hora'],
    'direccion' => $_POST['direccion'],
    'evento'    => $evento,
    'mensaje'   => $_POST['mensaje'],
    'modelo'    => $_POST['modelo'],
    'imagen'    => $imagenFinal
];

file_put_contents($directorioJSON . $codigo . ".json", json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Configurar fecha bonita
setlocale(LC_TIME, 'es_ES.UTF-8');
$timestamp = strtotime($datos['fecha']);
$fechaBonita = strftime("%A %e de %B", $timestamp);
$fechaBonita = ucfirst($fechaBonita);

// Imagen de fondo según modelo
$modeloPath = "invitaciones/img/modelos/{$datos['modelo']}.png";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Invitación Generada</title>
    <style>
        .tarjeta-final {
            position: relative;
            background: url('<?= $modeloPath ?>') no-repeat center/cover;
            width: 100%;
            max-width: 600px;
            margin: 18px auto;
            border-radius: 20px;
            padding: 9vw 9vw 10vw;
            color: #222;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
        }
        .tarjeta-final img {
            width: 30vw;
            max-width: 140px;
            aspect-ratio: 1 / 1;
            height: auto;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            margin: 0 auto 20px auto;
            display: block;
        }
        .tarjeta-final h2 {
            font-family: 'Great Vibes', cursive;
            font-size: 8vw;
            max-font-size: 46px;
            margin: 0;
        }
        .tarjeta-final h3 {
            font-size: 5vw;
            max-font-size: 24px;
            margin-top: 10px;
        }
        .tarjeta-final p {
            margin: 15px 0 10px;
            font-size: 4vw;
            max-font-size: 18px;
        }
        .tarjeta-final p:last-of-type {
            margin-top: 10px;
            font-style: italic;
            font-size: 3.8vw;
            max-font-size: 16px;
        }
        .download-button {
            padding: 10px 20px;
            background: #fff;
            color: #333;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    <div class="tarjeta-final">
<img src="<?= htmlspecialchars($directorioIMG . $imagenFinal) ?>" alt="Foto invitado">
        <h2><?= htmlspecialchars($datos['nombre']) ?></h2>
        <h3><?= htmlspecialchars($evento) ?></h3>
        <p>Será el <?= $fechaBonita ?> a las <?= htmlspecialchars($datos['hora']) ?> hs</p>
        <p>En <?= htmlspecialchars($datos['direccion']) ?></p>
        <p>"<?= nl2br(htmlspecialchars($datos['mensaje'])) ?>"</p>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <button class="download-button" onclick="descargarImagen()">Descargar invitación</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        window.descargarImagen = function() {
            const tarjeta = document.querySelector('.tarjeta-final');
            if (!tarjeta) {
                alert("No se encontró la tarjeta para descargar.");
                return;
            }

            const img = tarjeta.querySelector('img');
            if (!img.complete) {
                img.onload = function() {
                    html2canvas(tarjeta).then(canvas => {
                        const link = document.createElement('a');
                        link.download = 'invitacion.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    });
                };
            } else {
                html2canvas(tarjeta).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'invitacion.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            }
        };
    </script>
</body>
</html>
