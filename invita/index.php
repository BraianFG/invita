<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invitaciones Digitales</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      line-height: 1.6;
      color: #1a202c;
      overflow-x: hidden;
    }

    /* Hero Section con gradiente animado */
    .hero {
      min-height: 100vh;
      background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Partículas flotantes */
    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="30" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="10" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
      animation: float 20s linear infinite;
      pointer-events: none;
    }

    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      100% { transform: translateY(-100px) rotate(360deg); }
    }

    .hero-content {
      text-align: center;
      color: white;
      z-index: 2;
      max-width: 800px;
      padding: 0 20px;
      position: relative;
    }

    .hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(3rem, 8vw, 6rem);
      font-weight: 900;
      margin-bottom: 24px;
      text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      animation: fadeInUp 1s ease-out;
    }

    .hero p {
      font-size: clamp(1.2rem, 3vw, 1.8rem);
      margin-bottom: 48px;
      font-weight: 300;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 1s ease-out 0.2s both;
    }

    /* CTA Button con efecto wow */
    .cta-button {
      display: inline-block;
      padding: 20px 50px;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(20px);
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50px;
      color: white;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.2rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      animation: fadeInUp 1s ease-out 0.4s both;
    }

    .cta-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      transition: left 0.6s;
    }

    .cta-button:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
      border-color: rgba(255, 255, 255, 0.8);
      background: rgba(255, 255, 255, 0.25);
    }

    .cta-button:hover::before {
      left: 100%;
    }

    /* Features Section */
    .features-section {
      padding: 120px 20px;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      position: relative;
    }

    .features-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.3), transparent);
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .section-header {
      text-align: center;
      margin-bottom: 80px;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 700;
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 16px;
    }

    .section-subtitle {
      font-size: 1.3rem;
      color: #4a5568;
      font-weight: 300;
      max-width: 600px;
      margin: 0 auto;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 40px;
      margin-top: 60px;
    }

    .feature-card {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 24px;
      padding: 48px 32px;
      text-align: center;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: -1;
    }

    .feature-card:hover {
      transform: translateY(-15px) scale(1.02);
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
      border-color: rgba(102, 126, 234, 0.3);
    }

    .feature-card:hover::before {
      opacity: 1;
    }

    .feature-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 32px;
      border-radius: 20px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: white;
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
      transition: all 0.4s ease;
    }

    .feature-card:hover .feature-icon {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }

    .feature-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 16px;
    }

    .feature-description {
      font-size: 1.1rem;
      color: #4a5568;
      line-height: 1.7;
      font-weight: 400;
    }

    /* CTA Section Final */
    .final-cta {
      padding: 100px 20px;
      background: linear-gradient(135deg, #1a202c, #2d3748);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .final-cta::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><pattern id="stars" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23stars)"/></svg>');
      animation: twinkle 3s ease-in-out infinite alternate;
    }

    @keyframes twinkle {
      0% { opacity: 0.3; }
      100% { opacity: 0.8; }
    }

    .final-cta-content {
      position: relative;
      z-index: 2;
      max-width: 600px;
      margin: 0 auto;
    }

    .final-cta h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 900;
      color: white;
      margin-bottom: 24px;
      text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .final-cta p {
      font-size: 1.3rem;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 48px;
      font-weight: 300;
    }

    .final-cta-button {
      display: inline-flex;
      align-items: center;
      padding: 24px 60px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 700;
      font-size: 1.3rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
      position: relative;
      overflow: hidden;
    }

    .final-cta-button i {
      margin-right: 12px;
      font-size: 1.4rem;
    }

    .final-cta-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.6s;
    }

    .final-cta-button:hover {
      transform: translateY(-8px) scale(1.05);
      box-shadow: 0 25px 60px rgba(102, 126, 234, 0.4);
    }

    .final-cta-button:hover::before {
      left: 100%;
    }

    /* Animaciones de entrada */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(60px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 0.8s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .features-grid {
        grid-template-columns: 1fr;
        gap: 30px;
      }

      .feature-card {
        padding: 40px 24px;
      }

      .hero {
        padding: 40px 20px;
      }

      .features-section {
        padding: 80px 20px;
      }

      .final-cta {
        padding: 80px 20px;
      }

      .final-cta-button {
        padding: 20px 40px;
        font-size: 1.1rem;
      }
    }

    /* Scroll smooth */
    html {
      scroll-behavior: smooth;
    }

    /* Intersection Observer para animaciones */
    .animate-on-scroll {
      opacity: 0;
      transform: translateY(50px);
      transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .animate-on-scroll.animate {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body>

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

  <script>
    // Intersection Observer para animaciones
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate');
        }
      });
    }, observerOptions);

    // Observar todos los elementos con la clase animate-on-scroll
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
      observer.observe(el);
    });

    // Agregar delays escalonados a las cards
    document.querySelectorAll('.feature-card').forEach((card, index) => {
      card.style.transitionDelay = `${index * 0.2}s`;
    });

    // Smooth scroll para los enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Parallax sutil en el hero
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const hero = document.querySelector('.hero');
      if (hero) {
        hero.style.transform = `translateY(${scrolled * 0.5}px)`;
      }
    });
  </script>

</body>
</html>
