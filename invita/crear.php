<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Preconexiones recomendadas -->
<!-- Conexiones anticipadas para mejorar la carga de recursos externos -->
<link rel="preconnect" href="https://cdnjs.cloudflare.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Preload de fuentes de Google con carga diferida (evita bloqueo de renderizado) -->
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap">
</noscript>

<?php include "assets/php/head.php"; ?>

<!-- Tus estilos locales (bloqueantes pero necesarios para render) -->
<link rel="stylesheet" href="./assets/css/crear.css">
<link rel="stylesheet" href="./assets/css/nav.css">
<link rel="stylesheet" href="./assets/css/footer.css">

</head>
<body>
  <?php include "assets/php/navbar.php"; ?>

  <!-- JS diferido -->
  <script src="assets/js/navbar.js" defer></script>

  <section class="fondo-mensaje">
    <div class="container">
      <h3>Creá tu invitación</h3>
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
        </div>
        
        <!-- Este bloque va por fuera del select y su input-wrapper -->
        <div class="form-group" id="otroEventoContainer" style="display: none;">
          <label for="otroEvento">Especifique tipo de evento</label>
          <div class="input-wrapper">
            <input type="text" id="otroEvento" name="otroEvento" placeholder="Describí tu evento">
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

   <!-- Imagen -->
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

   <div class="form-group">
            <label><i class="fas fa-images"></i> Elegí el modelo de invitación</label>
            <div class="scroll-modelos" id="modeloSelector">
              <div class="modelo seleccionado" data-modelo="modelo1">
                <img src="invitaciones/img/modelos/modelo1.png" width="48" height="48" alt="Modelo 1" loading="lazy">
              </div>
              <div class="modelo" data-modelo="modelo2">
                <img src="invitaciones/img/modelos/modelo2.png" width="48" height="48" alt="Modelo 2" loading="lazy">
              </div>
              <div class="modelo" data-modelo="modelo3">
                <img src="invitaciones/img/modelos/modelo3.png" width="48" height="48" alt="Modelo 3" loading="lazy">
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


  <!-- Scripts (usando defer) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
  <script src="assets/js/verImagen.js" defer></script>
  <script src="assets/js/seleccionar.js" defer></script>
  <script src="assets/js/footer.js" defer></script>
  <script src="assets/js/footer-date.js" defer></script>

  <!-- Script inline para preview, sin bloqueo -->
  
</body>
</html>
