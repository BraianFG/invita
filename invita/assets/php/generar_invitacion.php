<?php  
header("Content-Type: image/png");

$folder      = __DIR__ . '/../../invitaciones';
$fontPath    = __DIR__ . '/../../fonts/OpenSans-Regular.ttf';
$fontItalic  = __DIR__ . '/../../fonts/GreatVibes-Regular.ttf';


$codigo = isset($_GET['codigo']) ? basename($_GET['codigo']) : '';
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $codigo)) {
    http_response_code(400);
    exit;
}

$archivoJson = $folder . '/' . $codigo . '.json';
if (!file_exists($archivoJson)) {
    http_response_code(404);
    exit;
}

$data = json_decode(file_get_contents($archivoJson), true);
if (!$data) {
    http_response_code(500);
    exit;
}

$fechaObj = DateTime::createFromFormat('Y-m-d', $data['fecha']);
$fmt = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, "EEEE d 'de' MMMM ");
$fechaNatural = ucfirst($fmt->format($fechaObj));

$ancho = 800;
$alto = 600;
$imagen = imagecreatetruecolor($ancho, $alto);

// Colores
$colorClaro = imagecolorallocate($imagen, 255, 248, 240);
$colorDegradadoInicio = [255, 237, 230];
$colorDegradadoFin = [255, 210, 190];
$colorTextoPrincipal = imagecolorallocate($imagen, 65, 30, 15);
$colorTextoSecundario = imagecolorallocate($imagen, 120, 80, 50);
$colorSombraTexto = imagecolorallocatealpha($imagen, 220, 210, 200, 70);
$colorMarco = imagecolorallocatealpha($imagen, 180, 140, 110, 70); // marco más suave con alpha
$colorDecoracion = imagecolorallocate($imagen, 200, 120, 90);
$colorFondoImgMarco = imagecolorallocate($imagen, 255, 255, 255);

// Fondo degradado vertical
for ($y = 0; $y < $alto; $y++) {
    $r = (int)($colorDegradadoInicio[0] + ($colorDegradadoFin[0] - $colorDegradadoInicio[0]) * ($y / $alto));
    $g = (int)($colorDegradadoInicio[1] + ($colorDegradadoFin[1] - $colorDegradadoInicio[1]) * ($y / $alto));
    $b = (int)($colorDegradadoInicio[2] + ($colorDegradadoFin[2] - $colorDegradadoInicio[2]) * ($y / $alto));
    $colorLinea = imagecolorallocate($imagen, $r, $g, $b);
    imageline($imagen, 0, $y, $ancho, $y, $colorLinea);
}
// Textura puntillada
for ($i = 0; $i < 2000; $i++) {
    $x = rand(0, $ancho - 1);
    $y = rand(0, $alto - 1);
    imagesetpixel($imagen, $x, $y, imagecolorallocatealpha($imagen, 230, 220, 210, 80));
}

// Marco exterior (grosor 6, más suave)
$grosorMarco = 6;
for ($i = 0; $i < $grosorMarco; $i++) {
    $alpha = 70 - ($i * 8);
    if ($alpha < 10) $alpha = 10;
    $colorMarcoSemi = imagecolorallocatealpha($imagen, 180, 140, 110, $alpha);
    imagerectangle($imagen, $i, $i, $ancho - 1 - $i, $alto - 1 - $i, $colorMarcoSemi);
}

// --- Imagen con marco y sombra ---
// Tamaño máximo imagen
$maxWidthImg = 180;
$maxHeightImg = 140;

// Posición imagen a la izquierda con margen X fijo
$posImgX = 40;

// Centrar imagen verticalmente
$posImgY = (int)(($alto - $maxHeightImg) / 2);

// Caja para sombra y fondo (ajustamos según la nueva posición)
$shadowOffset = 8;
$rectX1 = $posImgX - 8;
$rectY1 = $posImgY - 8;
$rectX2 = $posImgX + $maxWidthImg + 8;
$rectY2 = $posImgY + $maxHeightImg + 8;

// Sombra más suave y difusa
for ($s = 0; $s < $shadowOffset; $s++) {
    $alpha = 100 - $s * 12;
    if ($alpha < 30) $alpha = 30;
    $shadowColor = imagecolorallocatealpha($imagen, 0, 0, 0, $alpha);
    imagefilledrectangle($imagen, $rectX1 + $s, $rectY1 + $s, $rectX2 + $s, $rectY2 + $s, $shadowColor);
}

// Fondo blanco para imagen
imagefilledrectangle($imagen, $rectX1, $rectY1, $rectX2, $rectY2, $colorFondoImgMarco);

// Marco fino para la imagen
imagerectangle($imagen, $rectX1, $rectY1, $rectX2, $rectY2, $colorMarco);

// Cargar imagen del invitado
$rutaImg = $folder . '/' . $data['imagen'];
if (file_exists($rutaImg)) {
    $ext = strtolower(pathinfo($rutaImg, PATHINFO_EXTENSION));
    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $imgSubida = imagecreatefromjpeg($rutaImg);
            break;
        case 'png':
            $imgSubida = imagecreatefrompng($rutaImg);
            break;
        case 'gif':
            $imgSubida = imagecreatefromgif($rutaImg);
            break;
        case 'webp':
            $imgSubida = imagecreatefromwebp($rutaImg);
            break;
        default:
            $imgSubida = null;
    }

    if ($imgSubida) {
        $origW = imagesx($imgSubida);
        $origH = imagesy($imgSubida);

        // Calcular escala para ajustarse dentro de maxWidthImg x maxHeightImg
        $ratio = min($maxWidthImg / $origW, $maxHeightImg / $origH);
        $newW = (int)($origW * $ratio);
        $newH = (int)($origH * $ratio);

        // Centrar la imagen dentro del área
        $posXImg = $posImgX + (int)(($maxWidthImg - $newW) / 2);
        $posYImg = $posImgY + (int)(($maxHeightImg - $newH) / 2);

        imagecopyresampled($imagen, $imgSubida, $posXImg, $posYImg, 0, 0, $newW, $newH, $origW, $origH);
        imagedestroy($imgSubida);
    }
}

// Funciones de texto con sombra
function imagettftextWithShadow($img, $size, $angle, $x, $y, $textColor, $shadowColor, $fontFile, $text)
{
    imagettftext($img, $size, $angle, $x + 2, $y + 2, $shadowColor, $fontFile, $text);
    imagettftext($img, $size, $angle, $x, $y, $textColor, $fontFile, $text);
}

function dibujarTextoMultilineaConSombra($img, $text, $size, $x, $y, $colorTexto, $colorSombra, $font, $maxWidth, $lineHeight)
{
    $palabras = explode(' ', $text);
    $linea = '';
    foreach ($palabras as $palabra) {
        $test = $linea . $palabra . ' ';
        $caja = imagettfbbox($size, 0, $font, $test);
        $anchoTexto = $caja[2] - $caja[0];
        if ($anchoTexto > $maxWidth) {
            imagettftextWithShadow($img, $size, 0, $x, $y, $colorTexto, $colorSombra, $font, trim($linea));
            $y += $lineHeight;
            $linea = $palabra . ' ';
        } else {
            $linea = $test;
        }
    }
    if (!empty($linea)) {
        imagettftextWithShadow($img, $size, 0, $x, $y, $colorTexto, $colorSombra, $font, trim($linea));
        $y += $lineHeight;
    }
    return $y;
}

// --- Texto principal ---
// Posición texto a la derecha de la imagen, con separación horizontal
$xTexto = $posImgX + $maxWidthImg + 30;

// Ajustamos la posición vertical inicial para que quede más arriba y sin tanto margen
$yTexto = $posImgY - 80; 
$lineHeight = 30;

$texto = "Querido/a {$data['nombre']},\n\n" .
    "Con mucha alegría queremos invitarte a nuestro evento especial:\n{$data['evento']}.\n" .
    "Será el {$fechaNatural} a las {$data['hora']} en {$data['direccion']}.\n\n" .
    "Tu presencia hará este momento aún más significativo para nosotros.\n\n";

$parrafos = explode("\n", $texto);
foreach ($parrafos as $parrafo) {
    $parrafo = trim($parrafo);
    if ($parrafo !== '') {
        $yTexto = dibujarTextoMultilineaConSombra($imagen, $parrafo, 20, $xTexto, $yTexto, $colorTextoPrincipal, $colorSombraTexto, $fontPath, 460, $lineHeight);
        // Quité el incremento extra para evitar corrimiento vertical excesivo
    }
}

// Mensaje opcional sin comillas
if (!empty($data['mensaje'])) {
    $mensaje = $data['mensaje'];
    $yTexto += 15;
    $yTexto = dibujarTextoMultilineaConSombra($imagen, $mensaje, 18, $xTexto + 20, $yTexto, $colorTextoSecundario, $colorSombraTexto, $fontPath, 440, $lineHeight);
}

// Texto firma con fuente caligráfica
if (file_exists($fontItalic)) {
    imagettftextWithShadow($imagen, 28, 0, $xTexto, $yTexto + 50, $colorDecoracion, $colorSombraTexto, $fontItalic, "Con cariño,");
    imagettftextWithShadow($imagen, 38, 0, $xTexto, $yTexto + 95, $colorDecoracion, $colorSombraTexto, $fontItalic, "¡Te esperamos!");
}

// Decoración: corazones en esquina inferior derecha
function drawHeart($im, $cx, $cy, $size, $color) {
    $radius = $size / 4;
    imagefilledarc($im, $cx - $radius, $cy - $radius, $radius * 2, $radius * 2, 0, 360, $color, IMG_ARC_PIE);
    imagefilledarc($im, $cx + $radius, $cy - $radius, $radius * 2, $radius * 2, 0, 360, $color, IMG_ARC_PIE);
    $points = [
        $cx - 2 * $radius, $cy - $radius,
        $cx + 2 * $radius, $cy - $radius,
        $cx, $cy + 2 * $radius,
    ];
    imagefilledpolygon($im, $points, 3, $color);
}

for ($i = 0; $i < 6; $i++) {
    $offsetX = $ancho - 60 + rand(-10, 10);
    $offsetY = $alto - 60 + rand(-10, 10);
    $size = rand(12, 22);
    drawHeart($imagen, $offsetX, $offsetY, $size, $colorDecoracion);
}

imagepng($imagen);
imagedestroy($imagen);
?>
