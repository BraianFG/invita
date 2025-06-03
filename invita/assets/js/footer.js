document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById('invitacionForm');
  const respuesta = document.getElementById('respuesta');
  const modelos = document.querySelectorAll(".modelo");
  const inputModelo = document.getElementById("modeloSeleccionado");
  const inputImagen = document.getElementById('imagen');
  const labelImagen = document.querySelector('.file-input-label span');
  const selectEvento = document.getElementById('evento');
  const otroEventoContainer = document.getElementById('otroEventoContainer');
  const submitBtn = document.querySelector('.submit-btn');

  // MANEJO DE MODELOS SELECCIONADOS
  modelos.forEach(modelo => {
    modelo.addEventListener("click", (e) => {
      e.preventDefault();
      modelos.forEach(m => m.classList.remove("seleccionado"));
      modelo.classList.add("seleccionado");
      inputModelo.value = modelo.dataset.modelo;
    });
  });

  // MANEJO DEL CAMBIO DE ARCHIVO
  inputImagen?.addEventListener('change', function () {
    if (this.files.length > 0) {
      labelImagen.textContent = this.files[0].name;
    } else {
      labelImagen.textContent = 'Seleccionar imagen';
    }
  });

  // CAMPO CONDICIONAL "OTRO EVENTO"
  selectEvento.addEventListener('change', function () {
    if (this.value === 'otro') {
      otroEventoContainer.classList.add('show');
    } else {
      otroEventoContainer.classList.remove('show');
    }
  });

  // ENVÍO DEL FORMULARIO
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const tipoEvento = selectEvento.value;
    const otroEvento = document.getElementById('otroEvento').value;

    formData.set('evento', tipoEvento === 'otro' ? otroEvento.trim() : tipoEvento);

    respuesta.style.display = 'none';
    respuesta.innerHTML = '';
    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<i class="fas fa-magic"></i> Creando Invitación...';

    fetch('assets/php/guardar.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        submitBtn.classList.remove('loading');
        submitBtn.innerHTML = '<i class="fas fa-magic"></i> Crear Invitación';

        if (data.success && data.file) {
          const imgUrl = `invitaciones/img/inv_${encodeURIComponent(data.file)}.png`;

          // Generar mensaje natural
          const partes = [];
          if (data.evento && data.nombre) {
            partes.push(`¡Estás invitado al ${data.evento} de ${data.nombre}! 🎉`);
          }
          if (data.mensaje) {
            partes.push(data.mensaje);
          }
          if (data.fecha && data.hora) {
            partes.push(`Será el día ${data.fecha} a las ${data.hora}.`);
          } else if (data.fecha) {
            partes.push(`Será el día ${data.fecha}.`);
          } else if (data.hora) {
            partes.push(`Será a las ${data.hora}.`);
          }
          if (data.direccion) {
            partes.push(`Te esperamos en ${data.direccion}.`);
          }

          const mensajeNatural = partes.join(' ');

          respuesta.className = 'message success';
          respuesta.style.display = 'block';
          respuesta.innerHTML = `
            <p>✅ ¡Invitación generada con éxito!</p>
            <h1 style="font-style: italic; margin-top: 10px; color: #555;">${mensajeNatural}</h1>
            <img src="${imgUrl}" alt="Invitación generada" style="max-width:100%; border-radius:12px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); margin-top: 15px;">
            <div style="margin-top: 15px;">
              <a href="${imgUrl}" download="invitacion_${data.file}.png" class="btn-descargar">
                <i class="fas fa-download"></i> Descargar
              </a>
              <a href="https://wa.me/?text=${encodeURIComponent('¡Hola! Te comparto mi invitación: ' + window.location.origin + '/' + imgUrl)}"
                 target="_blank" class="btn-whatsapp">
                <i class="fab fa-whatsapp"></i> Compartir
              </a>
            </div>
          `;
        } else {
          respuesta.className = 'message error';
          respuesta.style.display = 'block';
          respuesta.textContent = data.message || '❌ Ocurrió un error al generar la invitación.';
        }
      })
      .catch(error => {
        console.error('Error:', error);
        submitBtn.classList.remove('loading');
        submitBtn.innerHTML = '<i class="fas fa-magic"></i> Crear Invitación';
        respuesta.className = 'message error';
        respuesta.style.display = 'block';
        respuesta.textContent = '❌ Ocurrió un error inesperado.';
      });
  });
});
