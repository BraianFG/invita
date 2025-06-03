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

  // ==============================
  // MANEJO DE MODELOS SELECCIONADOS
  // ==============================
  modelos.forEach(modelo => {
    modelo.addEventListener("click", (e) => {
      e.preventDefault();
      modelos.forEach(m => m.classList.remove("seleccionado"));
      modelo.classList.add("seleccionado");
      inputModelo.value = modelo.dataset.modelo;
    });
  });

  // ==============================
  // MANEJO DEL CAMBIO DE ARCHIVO
  // ==============================
  inputImagen?.addEventListener('change', function () {
    if (this.files.length > 0) {
      labelImagen.textContent = this.files[0].name;
    } else {
      labelImagen.textContent = 'Seleccionar imagen';
    }
  });

  // ==============================
  // CAMPO CONDICIONAL "OTRO EVENTO"
  // ==============================
  selectEvento.addEventListener('change', function () {
    if (this.value === 'otro') {
      otroEventoContainer.classList.add('show');
    } else {
      otroEventoContainer.classList.remove('show');
    }
  });

  // ==============================
  // ENVÍO DEL FORMULARIO
  // ==============================
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const tipoEvento = selectEvento.value;
    const otroEvento = document.getElementById('otroEvento').value;

    // Reemplazar el valor de evento si se seleccionó "otro"
    formData.set('evento', tipoEvento === 'otro' ? otroEvento.trim() : tipoEvento);

    // Estado de carga
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
        // Redirigir al ver_invitaciones.php con la URL de la imagen generada
         //window.location.href = `assets/php/ver_invitaciones.php?file=${encodeURIComponent(data.file)}`;
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
