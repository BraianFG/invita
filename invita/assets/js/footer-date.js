const fechaInput = document.getElementById('fecha');
  const hoy = new Date();
  const yearActual = hoy.getFullYear();

  // Fecha mínima: 1 de enero del año actual
  const minFecha = `${yearActual}-01-01`;

  // Fecha máxima: 31 de diciembre del año actual
  const maxFecha = `${yearActual}-12-31`;

  // Setear atributos min y max
  fechaInput.setAttribute('min', minFecha);
  fechaInput.setAttribute('max', maxFecha);
