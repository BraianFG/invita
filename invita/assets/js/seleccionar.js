  // Mostrar campo "otro" si corresponde
  document.getElementById('evento').addEventListener('change', function () {
    const otro = document.getElementById('otroEventoContainer');
    otro.style.display = (this.value === 'otro') ? 'block' : 'none';
  });

  // Selección visual del modelo
  const modelos = document.querySelectorAll('.modelo');
  const inputModelo = document.getElementById('modeloSeleccionado');
  modelos.forEach(modelo => {
    modelo.addEventListener('click', () => {
      modelos.forEach(m => m.classList.remove('seleccionado'));
      modelo.classList.add('seleccionado');
      inputModelo.value = modelo.dataset.modelo;
    });
  });