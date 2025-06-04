<!DOCTYPE html>
<html lang="es">
<head>
  <?php include "assets/php/head.php"; ?>
  <link rel="stylesheet" href="./assets/css/crear.css">
  <link rel="stylesheet" href="./assets/css/nav.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
</head>
<body>

  <?php include "assets/php/navbar.php" ?>
  <script src="assets/js/navbar.js"></script>
<section class="fondo-mensaje">
 <div class="container">
    <h1>Creá tu invitación</h1>
    <p>Completá los datos de tu evento y comenzá con tu invitación digital personalizada</p>
  </div>
</section>
<section class="main-section">
  <div class="container">
    <div class="form-container fade-in-up">
      <form id="invitacionForm" enctype="multipart/form-data">
        <div class="form-group">
          <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha del evento</label>
          <div class="input-wrapper">
            <input type="date" id="fecha" name="fecha" required>
          </div>
        </div>

        <div class="form-group">
          <label for="hora"><i class="fas fa-clock"></i> Horario</label>
          <div class="input-wrapper">
            <input type="time" id="hora" name="hora" required>
          </div>
        </div>

        <div class="form-group">
          <label for="direccion"><i class="fas fa-map-marker-alt"></i> Dirección</label>
          <div class="input-wrapper">
            <input type="text" id="direccion" name="direccion" placeholder="Ingresá la dirección del evento" required>
          </div>
        </div>

        <div class="form-group">
          <label for="evento"><i class="fas fa-star"></i> Tipo de evento</label>
          <div class="input-wrapper">
            <select id="evento" name="evento" required>
              <option value="">Seleccionar tipo de evento...</option>
              <option value="boda">💍 Boda</option>
              <option value="cumpleaños">🎂 Cumpleaños</option>
              <option value="baby_shower">👶 Baby Shower</option>
              <option value="bautismo">✨ Bautismo</option>
              <option value="otro">🎉 Otro</option>
            </select>
          </div>

          <div id="otroEventoContainer" class="conditional-field" style="display: none;">
            <label for="otroEvento">Especifíque tipo de evento</label>
            <div class="input-wrapper">
              <input type="text" id="otroEvento" name="otroEvento" placeholder="Describí tu evento">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="mensaje"><i class="fas fa-heart"></i> Mensaje personalizado</label>
          <div class="input-wrapper">
            <textarea id="mensaje" name="mensaje" placeholder="Escribí un mensaje especial para tus invitados..." required></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="nombre"><i class="fas fa-user"></i> Nombre del invitado</label>
          <div class="input-wrapper">
            <input type="text" id="nombre" name="nombre" placeholder="Nombre, apellido y/o apodo de la persona a invitar" required>
          </div>
        </div>

<div class="form-group">
  <label><i class="fas fa-image"></i> Imagen para la tarjeta</label>
  <div class="file-input-wrapper">
    <input type="file" id="imagen" name="imagen" accept="image/*" required>
    <label for="imagen" class="file-input-label">
      <i class="fas fa-cloud-upload-alt"></i>
      <span>Seleccionar imagen</span>
    </label>
  </div>
  <div id="preview" style="margin-top: 10px;"></div>
</div>

<script>
    document.getElementById('imagen').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    if (file) {
        if (!file.type.startsWith('image/')) {
            alert('Por favor, selecciona un archivo de imagen válido.');
            this.value = ''; // Limpia el input
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '70px';
            img.style.width = '70px'; // Fija el ancho
            img.style.height = '70px'; // Fija el alto para hacerlo cuadrado
            img.style.borderRadius = '4px'; // Ajusta el borde redondeado
            img.style.objectFit = 'cover'; // Asegura que la imagen llene el espacio
            img.style.display = 'block'; // Asegura que la imagen sea un bloque
            img.style.margin = '0 auto'; // Centra la imagen horizontalmente
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});
</script>

     <div class="form-group">
  <label><i class="fas fa-images"></i> Elegí el modelo de invitación</label>
  <div class="scroll-modelos" id="modeloSelector">
    <div class="modelo seleccionado" data-modelo="modelo1">
      <img src="invitaciones/img/modelos/modelo1.png" alt="Modelo 1">
    </div>
    <div class="modelo" data-modelo="modelo2">
      <img src="invitaciones/img/modelos/modelo2.png" alt="Modelo 2">
    </div>
    <div class="modelo" data-modelo="modelo3">
      <img src="invitaciones/img/modelos/modelo3.png" alt="Modelo 3">
    </div>
  </div>
  <input type="hidden" name="modelo" id="modeloSeleccionado" value="modelo1">
</div>


        <div class="message" id="respuesta" style="display: none;"></div>

        <button type="submit" class="submit-btn">
          <i class="fas fa-magic"></i> Crear Invitación
        </button>
      </form>
    </div>
  </div>
</section>

<section class="results-section" id="ver_invitaciones" style="display: none;">
  <div class="container">
    <div class="invitation-card fade-in-up">
      <!-- Resultado dinámico -->
    </div>
  </div>
</section>

  <?php include "assets/php/footer.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="assets/js/seleccionar.js"></script>
<script src="assets/js/footer.js"></script>
<script src="assets/js/footer-date.js"></script>
</body>
</html>
