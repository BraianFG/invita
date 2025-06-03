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

  fetch('assets/php/guardar.php', {
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
      const imgUrl = 'assets/php/generar_invitacion.php?codigo=' + encodeURIComponent(data.codigo) + '&t=' + Date.now();

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
