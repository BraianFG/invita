<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Invitaciones Digitales</title>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans&display=swap" rel="stylesheet"/>
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
    body {
      margin: 0;
      font-family: 'Open Sans', sans-serif;
      background: linear-gradient(to bottom right, #fff0f5, #ffe4e1);
      color: #333;
      text-align: center;
    }

    header {
      padding: 50px 20px;
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    header h1 {
      font-family: 'Great Vibes', cursive;
      font-size: 3em;
      color: #d87093;
      margin-bottom: 10px;
    }

    header p {
      font-size: 1.2em;
      color: #555;
    }

    #formulario {
      padding: 40px 20px;
      background: #fff0f5;
    }

    form {
      max-width: 600px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: #444;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 1em;
    }

    button {
      background: #d87093;
      color: white;
      border: none;
      padding: 15px 30px;
      border-radius: 30px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #c06085;
    }

    .mensaje-envio {
      text-align: center;
      margin-top: 20px;
      color: green;
      font-weight: bold;
    }

    #ver_invitaciones img {
      max-width: 100%;
      margin-top: 20px;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    #ver_invitaciones{
      background: #fff0f5;
    }
    
  </style>
</head>
<body>

<header>
  <h1>Creá tu invitación</h1>
  <p>Completá los datos de tu evento y comenzá con tu invitación digital personalizada.</p>
</header>

<section id="formulario">
  <form id="invitacionForm" enctype="multipart/form-data">
    <label for="fecha">Fecha del evento</label>
    <input type="date" id="fecha" name="fecha" required>

    <label for="hora">Horario</label>
    <input type="time" id="hora" name="hora" required>

    <label for="direccion">Dirección</label>
    <input type="text" id="direccion" name="direccion" required>

    <label for="evento">Tipo de evento</label>
    <select id="evento" name="evento" required>
      <option value="">Seleccionar...</option>
      <option value="boda">Boda</option>
      <option value="cumpleaños">Cumpleaños</option>
      <option value="baby_shower">Baby Shower</option>
      <option value="bautismo">Bautismo</option>
      <option value="otro">Otro</option>
    </select>

    <div id="otroEventoContainer" style="display:none; margin-top:10px;">
      <label for="otroEvento">Especificar tipo de evento</label>
      <input type="text" id="otroEvento" name="otroEvento">
    </div>

    <label for="mensaje">Mensaje personalizado</label>
    <textarea id="mensaje" name="mensaje" rows="4" required></textarea>

    <label for="nombre">Nombre, apellido y/o apodo de la persona a invitar</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="imagen">Subir imagen para la tarjeta</label>
    <input type="file" id="imagen" name="imagen" accept="image/*" required>

    <button type="submit">Enviar datos</button>
  </form>

  <div class="mensaje-envio" id="respuesta"></div>
</section>

<section id="ver_invitaciones" style="padding: 40px 20px"></section>

<script>
document.getElementById('evento').addEventListener('change', function () {
  const otroEventoContainer = document.getElementById('otroEventoContainer');
  if (this.value === 'otro') {
    otroEventoContainer.style.display = 'block';
  } else {
    otroEventoContainer.style.display = 'none';
  }
});

document.getElementById('invitacionForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);
  const tipoEvento = document.getElementById('evento').value;
  const otroEvento = document.getElementById('otroEvento').value;

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
    contenedor.innerHTML = '';

    if (data.estado === 'ok') {
      const imgUrl = 'generar_invitacion.php?codigo=' + encodeURIComponent(data.codigo) + '&t=' + Date.now();

      const img = document.createElement('img');
      img.src = imgUrl;
      img.alt = 'Invitación generada';
      img.style.maxWidth = '400px';
      contenedor.appendChild(img);

      const info = document.createElement('div');
      info.textContent = `Código: ${data.codigo}`;
      contenedor.appendChild(info);

      const botonDescarga = document.createElement('a');
      botonDescarga.href = imgUrl;
      botonDescarga.download = 'invitacion_' + data.codigo + '.png';
      botonDescarga.textContent = '📥 Descargar invitación';
      botonDescarga.style.display = 'inline-block';
      botonDescarga.style.margin = '15px 10px';
      botonDescarga.style.padding = '10px 20px';
      botonDescarga.style.backgroundColor = '#d87093';
      botonDescarga.style.color = 'white';
      botonDescarga.style.borderRadius = '20px';
      botonDescarga.style.textDecoration = 'none';
      contenedor.appendChild(botonDescarga);

      const botonWhatsApp = document.createElement('a');
      const mensajeWA = `¡Hola! Te comparto una invitación: ${imgUrl}`;
      botonWhatsApp.href = `https://wa.me/?text=${encodeURIComponent(mensajeWA)}`;
      botonWhatsApp.target = '_blank';
      botonWhatsApp.textContent = '📤 Compartir por WhatsApp';
      botonWhatsApp.style.display = 'inline-block';
      botonWhatsApp.style.margin = '15px 10px';
      botonWhatsApp.style.padding = '10px 20px';
      botonWhatsApp.style.backgroundColor = '#25D366';
      botonWhatsApp.style.color = 'white';
      botonWhatsApp.style.borderRadius = '20px';
      botonWhatsApp.style.textDecoration = 'none';
      contenedor.appendChild(botonWhatsApp);
    } else {
      contenedor.textContent = 'Error: ' + (data.mensaje || 'Algo salió mal');
    }
  })
  .catch(err => {
    console.error(err);
    document.getElementById('ver_invitaciones').textContent = 'Error al enviar datos.';
  });
});
</script>

</body>
</html>
