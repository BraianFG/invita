<!DOCTYPE html>
<html lang="es">
<head>
  <?php include "assets/php/head.php" ?>
    <link rel="stylesheet" href="./assets/css/main.css">
 </head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include "assets/php/head.php" ?>
  <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/nav.css">
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
<script src="assets/js/main.js" defer></script>
<?php include "assets/php/footer.php" ?>
</body>
</html>