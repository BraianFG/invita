<!DOCTYPE html>
<html lang="es">
<head>
  <?php include "assets/php/head.php" ;

  ?>
  <link rel="stylesheet" href="./assets/css/footer.css">
</head>
  <body>

<header>
  <div class="container">
    <h1>Creá tu invitación</h1>
    <p>Completá los datos de tu evento y comenzá con tu invitación digital personalizada</p>
  </div>
</header>

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

          <div id="otroEventoContainer" class="conditional-field">
            <label for="otroEvento">Especificar tipo de evento</label>
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
        </div>

        <button type="submit" class="submit-btn">
          <i class="fas fa-magic"></i> Crear Invitación
        </button>
      </form>

      <div class="message" id="respuesta" style="display: none;"></div>
    </div>
  </div>
</section>

<section class="results-section" id="ver_invitaciones" style="display: none;">
  <div class="container">
    <div class="invitation-card fade-in-up">
      <!-- Contenido dinámico aquí -->
    </div>
  </div>
</section>

<script src="assets/js/footer.js"></script>
<footer>
    <?php include "assets/php/footer.php" ?>
</footer>

<script src="assets/js/footer-date.js"></script>
</body>
</html>