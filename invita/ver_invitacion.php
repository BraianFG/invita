<?php
$folder = __DIR__ . '/invitaciones';

$codigo = isset($_GET['codigo']) ? basename($_GET['codigo']) : '';
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $codigo) || !file_exists($folder . '/' . $codigo . '.json')) {
    die("Invitación no válida.");
}

$urlImagen = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']) . "/generar_invitacion.php?codigo=" . urlencode($codigo);

$urlDescarga = $urlImagen;

$mensajeWhatsApp = "¡Te invito a este evento! Mira la invitación aquí:\n$urlImagen";
$urlWhatsApp = "https://api.whatsapp.com/send?text=" . urlencode($mensajeWhatsApp);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Invitación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background: #fff8f0;
        }
        img {
            max-width: 90%;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        .btn {
            display: inline-block;
            margin: 15px 10px;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #3e8e41;
        }
        .btn.whatsapp {
            background-color: #25D366;
        }
        .btn.whatsapp:hover {
            background-color: #1ebe57;
        }
    </style>
</head>
<body>

    <h1>Invitación</h1>

    <img src="<?= htmlspecialchars($urlImagen) ?>" alt="Invitación" />
    
    <div>
        <a href="<?= htmlspecialchars($urlDescarga) ?>" download="invitacion_<?= htmlspecialchars($codigo) ?>.png" class="btn">Descargar</a>
        <a href="<?= htmlspecialchars($urlWhatsApp) ?>" target="_blank" class="btn whatsapp">Compartir por WhatsApp</a>
    </div>

</body>
</html>
