document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("invitacionForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const respuesta = document.getElementById("respuesta");
    const tarjeta = document.querySelector(".invitation-card");

    respuesta.style.display = "none";
    tarjeta.innerHTML = "Generando...";

    fetch('assets/php/guardar.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(html => {
      tarjeta.innerHTML = html;
      document.getElementById('ver_invitaciones').style.display = 'block';
      window.scrollTo({
        top: document.getElementById('ver_invitaciones').offsetTop,
        behavior: 'smooth'
      });
    })
    .catch(err => {
      console.error(err);
      respuesta.style.display = "block";
      respuesta.textContent = "Ocurrió un error al generar la invitación.";
    });
  });
});

function descargarImagen() {
  const tarjeta = document.querySelector('.tarjeta-final');

  if (!tarjeta) {
    alert("No se encontró la tarjeta para descargar.");
    return;
  }

  html2canvas(tarjeta).then(canvas => {
    const link = document.createElement('a');
    link.download = 'invitacion.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
  });
}
