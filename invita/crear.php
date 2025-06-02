<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Invitaciones Digitales</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  
  <!-- Meta generales -->
  <meta name="description" content="Creá tu invitación digital personalizada en segundos. Completá los datos de tu evento y compartila fácilmente.">
  <meta name="keywords" content="invitaciones digitales, tarjeta de invitación, crear invitación online, eventos, bodas, cumpleaños">
  <meta name="author" content="TuNombre o TuWeb">

  <!-- Open Graph para Facebook, WhatsApp, LinkedIn -->
  <meta property="og:title" content="Invitaciones Digitales Personalizadas">
  <meta property="og:description" content="Completá los datos de tu evento y generá tu tarjeta de invitación digital al instante.">
  <meta property="og:url" content="https://braianfg.com.ar/invitaciones">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Invitaciones Digitales">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Invitaciones Digitales Personalizadas">
  <meta name="twitter:description" content="Completá los datos de tu evento y generá tu invitación online lista para compartir.">
  <meta name="twitter:url" content="https://tusitio.com/invitaciones">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      color: #2d3748;
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Header moderno */
    header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      padding: 40px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
      z-index: -1;
    }

    header h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 700;
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 16px;
      position: relative;
    }

    header p {
      font-size: 1.25rem;
      color: #4a5568;
      font-weight: 300;
      max-width: 600px;
      margin: 0 auto;
    }

    /* Sección principal con glassmorphism */
    .main-section {
      padding: 80px 0;
      position: relative;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 24px;
      padding: 48px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      max-width: 700px;
      margin: 0 auto;
      position: relative;
    }

    .form-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
      border-radius: 24px;
      z-index: -1;
    }

    .form-group {
      margin-bottom: 32px;
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #2d3748;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
    }

    .input-wrapper {
      position: relative;
    }

    input, select, textarea {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 16px;
      font-size: 1rem;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      outline: none;
      font-family: 'Inter', sans-serif;
    }

    input:focus, select:focus, textarea:focus {
      border-color: #667eea;
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
      transform: translateY(-2px);
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    .file-input-wrapper {
      position: relative;
      overflow: hidden;
      display: inline-block;
      width: 100%;
    }

    .file-input-wrapper input[type=file] {
      position: absolute;
      left: -9999px;
    }

    .file-input-label {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px 20px;
      border: 2px dashed rgba(102, 126, 234, 0.4);
      border-radius: 16px;
      background: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 500;
      color: #4a5568;
    }

    .file-input-label:hover {
      border-color: #667eea;
      background: rgba(255, 255, 255, 0.7);
    }

    .file-input-label i {
      margin-right: 12px;
      font-size: 1.2rem;
      color: #667eea;
    }

    /* Botón principal con animación */
    .submit-btn {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      padding: 18px 48px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      position: relative;
      overflow: hidden;
      width: 100%;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .submit-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .submit-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    }

    .submit-btn:hover::before {
      left: 100%;
    }

    .submit-btn:active {
      transform: translateY(-1px);
    }

    /* Sección de resultados */
    .results-section {
      padding: 60px 0;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .invitation-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      text-align: center;
      max-width: 500px;
      margin: 0 auto;
    }

    .invitation-card img {
      max-width: 100%;
      height: auto;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      margin-bottom: 24px;
    }

    .code-display {
      background: linear-gradient(135deg, #f7fafc, #edf2f7);
      padding: 16px;
      border-radius: 12px;
      margin: 20px 0;
      font-family: 'Monaco', monospace;
      font-weight: 600;
      color: #2d3748;
      border-left: 4px solid #667eea;
    }

    .action-buttons {
      display: flex;
      gap: 16px;
      margin-top: 32px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .action-btn {
      display: inline-flex;
      align-items: center;
      padding: 14px 28px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      min-width: 180px;
      justify-content: center;
    }

    .download-btn {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    .whatsapp-btn {
      background: linear-gradient(135deg, #25D366, #128C7E);
      color: white;
    }

    .action-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
    }

    .action-btn i {
      margin-right: 8px;
      font-size: 1.1rem;
    }

    /* Campo condicional */
    .conditional-field {
      margin-top: 16px;
      opacity: 0;
      max-height: 0;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .conditional-field.show {
      opacity: 1;
      max-height: 200px;
    }

    /* Mensajes */
    .message {
      padding: 16px 24px;
      border-radius: 12px;
      margin: 20px 0;
      font-weight: 500;
      text-align: center;
    }

    .message.success {
      background: rgba(72, 187, 120, 0.1);
      color: #2f855a;
      border: 1px solid rgba(72, 187, 120, 0.3);
    }

    .message.error {
      background: rgba(245, 101, 101, 0.1);
      color: #c53030;
      border: 1px solid rgba(245, 101, 101, 0.3);
    }

    /* Animaciones */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .form-container {
        padding: 32px 24px;
        margin: 20px;
      }

      .action-buttons {
        flex-direction: column;
        align-items: stretch;
      }

      .action-btn {
        min-width: auto;
      }

      header {
        padding: 30px 0;
      }

      .main-section {
        padding: 40px 0;
      }
    }

    /* Loading state */
    .loading {
      opacity: 0.7;
      pointer-events: none;
    }

    .submit-btn.loading::after {
      content: '';
      width: 20px;
      height: 20px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s ease-in-out infinite;
      margin-left: 10px;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
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

<script>
// Manejo del campo condicional
document.getElementById('evento').addEventListener('change', function () {
  const otroEventoContainer = document.getElementById('otroEventoContainer');
  if (this.value === 'otro') {
    otroEventoContainer.classList.add('show');
  } else {
    otroEventoContainer.classList.remove('show');
  }
});

// Manejo del archivo
document.getElementById('imagen').addEventListener('change', function() {
  const label = document.querySelector('.file-input-label span');
  if (this.files.length > 0) {
    label.textContent = this.files[0].name;
  } else {
    label.textContent = 'Seleccionar imagen';
  }
});

// Envío del formulario
document.getElementById('invitacionForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);
  const tipoEvento = document.getElementById('evento').value;
  const otroEvento = document.getElementById('otroEvento').value;
  const submitBtn = document.querySelector('.submit-btn');
  const respuesta = document.getElementById('respuesta');

  // Estado de carga
  submitBtn.classList.add('loading');
  submitBtn.innerHTML = '<i class="fas fa-magic"></i> Creando Invitación...';

  if (tipoEvento === 'otro' && otroEvento.trim() !== '') {
    formData.set('evento', otroEvento);
  } else {
    formData.set('evento', tipoEvento);
  }

  fetch('guardar.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    const contenedor = document.getElementById('ver_invitaciones');
    const invitationCard = contenedor.querySelector('.invitation-card');
    
    // Resetear estado del botón
    submitBtn.classList.remove('loading');
    submitBtn.innerHTML = '<i class="fas fa-magic"></i> Crear Invitación';

    if (data.estado === 'ok') {
      const imgUrl = 'generar_invitacion.php?codigo=' + encodeURIComponent(data.codigo) + '&t=' + Date.now();

      invitationCard.innerHTML = `
        <h3 style="color: #667eea; margin-bottom: 24px; font-family: 'Playfair Display', serif;">
          <i class="fas fa-check-circle" style="color: #48bb78; margin-right: 8px;"></i>
          ¡Invitación creada exitosamente!
        </h3>
        
        <img src="${imgUrl}" alt="Invitación generada" style="max-width: 100%; border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);">
        
        <div class="code-display">
          <strong>Código:</strong> ${data.codigo}
        </div>
        
        <div class="action-buttons">
          <a href="${imgUrl}" download="invitacion_${data.codigo}.png" class="action-btn download-btn">
            <i class="fas fa-download"></i>
            Descargar
          </a>
          <a href="https://wa.me/?text=${encodeURIComponent('¡Hola! Te comparto una invitación: ' + imgUrl)}" 
             target="_blank" class="action-btn whatsapp-btn">
            <i class="fab fa-whatsapp"></i>
            Compartir
          </a>
        </div>
      `;

      contenedor.style.display = 'block';
      
      // Scroll suave a los resultados
      contenedor.scrollIntoView({ behavior: 'smooth' });

      // Mostrar mensaje de éxito
      respuesta.className = 'message success';
      respuesta.textContent = '✨ Tu invitación está lista para compartir';
      respuesta.style.display = 'block';

    } else {
      respuesta.className = 'message error';
      respuesta.textContent = 'Error: ' + (data.mensaje || 'Algo salió mal. Intentá nuevamente.');
      respuesta.style.display = 'block';
      contenedor.style.display = 'none';
    }
  })
  .catch(err => {
    console.error(err);
    submitBtn.classList.remove('loading');
    submitBtn.innerHTML = '<i class="fas fa-magic"></i> Crear Invitación';
    
    respuesta.className = 'message error';
    respuesta.textContent = 'Error al conectar con el servidor. Verificá tu conexión e intentá nuevamente.';
    respuesta.style.display = 'block';
  });
});
</script>

</body>
</html>
