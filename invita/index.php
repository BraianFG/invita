<!DOCTYPE html>
<html lang="es">
<head>
  <?php include "assets/php/head.php" ?>
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/nav.css">
     <link rel="stylesheet" href="./assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- NAVBAR -->
  <?php include "assets/php/navbar.php" ?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Invitaciones Digitales</h1>
      <p>Elegancia, creatividad y emoción en un solo click</p>
      <a href="crear.php" class="cta-button">
        <i class="fas fa-magic"></i>
        Crear Invitación
      </a>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section">
    <div class="container">
      <div class="section-header animate-on-scroll">
        <h2 class="section-title">¿Por qué elegirnos?</h2>
        <p class="section-subtitle">
          Transformamos tus momentos especiales en invitaciones extraordinarias.
        </p>
      </div>

      <div class="features-grid">
        <div class="feature-card animate-on-scroll">
          <div class="feature-icon">
            <i class="fas fa-palette"></i>
          </div>
          <h3 class="feature-title">Diseños Personalizados</h3>
          <p class="feature-description">
            Cada invitación es única, hecha a tu medida con atención a cada detalle para reflejar la esencia de tu evento.
          </p>
        </div>

        <div class="feature-card animate-on-scroll">
          <div class="feature-icon">
            <i class="fas fa-share-alt"></i>
          </div>
          <h3 class="feature-title">Fácil de Compartir</h3>
          <p class="feature-description">
            Enviala por WhatsApp, correo o redes sociales. Comparte tu alegría de manera rápida y efectiva con todos tus seres queridos.
          </p>
        </div>

        <div class="feature-card animate-on-scroll">
          <div class="feature-icon">
            <i class="fas fa-star"></i>
          </div>
          <h3 class="feature-title">Detalles Especiales</h3>
          <p class="feature-description">
            Agregá música, mapas, RSVP y más. Cada elemento está diseñado para crear una experiencia memorable e interactiva.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
<section id="beneficios" class="benefits-section">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <h2 class="section-title">Beneficios de Usar Nuestras Invitaciones</h2>
      <p class="section-subtitle">
        Descubre cómo nuestras invitaciones digitales hacen que tu evento sea inolvidable.
      </p>
    </div>

    <div class="benefits-grid flex">
      <!-- Ecológico -->
      <div class="benefit-card animate-on-scroll">
        <div class="benefit-icon">
          <i class="fas fa-leaf"></i>
        </div>
        <h3 class="benefit-title">Ecológico</h3>
        <p class="benefit-description">
          Reduce el uso de papel y contribuye al cuidado del medio ambiente con invitaciones 100% digitales.
        </p>
      </div>

      <!-- Ahorro de Tiempo -->
      <div class="benefit-card animate-on-scroll">
        <div class="benefit-icon">
          <i class="fas fa-clock"></i>
        </div>
        <h3 class="benefit-title">Ahorro de Tiempo</h3>
        <p class="benefit-description">
          Crea y envía tus invitaciones en minutos, sin necesidad de impresión o envíos físicos.
        </p>
      </div>

      <!-- Costo Efectivo -->
      <div class="benefit-card animate-on-scroll">
        <div class="benefit-icon">
          <i class="fas fa-wallet"></i>
        </div>
        <h3 class="benefit-title">Costo Efectivo</h3>
        <p class="benefit-description">
          Ahorra en costos de impresión y envío, obteniendo un diseño profesional a un precio accesible.
        </p>
      </div>
    </div>
  </div>
</section>


  <!-- Contact Section -->
<section id="contactos" class="contact-section">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <h2 class="section-title">Contáctanos</h2>
      <p class="section-subtitle">
        Estamos aquí para ayudarte a crear la invitación perfecta.
      </p>
    </div>

    <div class="contact-grid flex">
      <!-- Correo Electrónico -->
      <div class="contact-card animate-on-scroll">
        <div class="contact-icon">
          <i class="fas fa-envelope"></i>
        </div>
        <h3 class="contact-title">Correo Electrónico</h3>
        <p class="contact-description">
          Escríbenos a <a href="mailto:info@invitacionesdigitales.com">info@invitacionesdigitales.com</a> para cualquier consulta.
        </p>
      </div>

      <!-- WhatsApp -->
      <div class="contact-card animate-on-scroll">
        <div class="contact-icon">
          <i class="fab fa-whatsapp"></i>
        </div>
        <h3 class="contact-title">WhatsApp</h3>
        <p class="contact-description">
          Contáctanos directamente al <a href="https://wa.me/1234567890" target="_blank">+123 456 7890</a>.
        </p>
      </div>

      <!-- Telegram -->
      <div class="contact-card animate-on-scroll">
        <div class="contact-icon">
          <i class="fab fa-telegram"></i>
        </div>
        <h3 class="contact-title">Telegram</h3>
        <p class="contact-description">
          Únete a nuestro canal en <a href="https://t.me/invitacionesdigitales" target="_blank">@InvitacionesDigitales</a>.
        </p>
      </div>
    </div>
  </div>
</section>
 

  <!-- Final CTA -->
  <section class="final-cta">
    <div class="final-cta-content animate-on-scroll">
      <h2>¿Listo para comenzar?</h2>
      <p>
        Creá tu invitación digital en minutos y sorprendé a todos con un diseño único y profesional.
      </p>
      <a href="crear.php" class="final-cta-button">
        <i class="fas fa-rocket"></i>
        Empezar Ahora
      </a>
    </div>
  </section>
  <script src="assets/js/navbar.js" defer></script>
  <script src="assets/js/main.js" defer></script>
  <?php include "./assets/php/footer.php" ?>
</body>
</html>