<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invitaciones Digitales</title>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans&display=swap" rel="stylesheet">
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

    .features {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 40px 20px;
      gap: 20px;
    }

    .feature {
      background: white;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 300px;
      flex: 1;
      transition: transform 0.3s ease;
    }

    .feature:hover {
      transform: translateY(-5px);
    }

    .feature h3 {
      color: #d87093;
      margin-bottom: 10px;
    }

    .cta {
      margin: 40px 0;
    }

    .cta a {
      text-decoration: none;
      background: #d87093;
      color: white;
      padding: 15px 30px;
      border-radius: 30px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .cta a:hover {
      background: #c06085;
    }
  </style>
</head>
<body>

  <header>
    <h1>Invitaciones Digitales</h1>
    <p>Elegancia, creatividad y emoción en un solo clic.</p>
  </header>

  <section class="features">
    <div class="feature">
      <h3>Diseños Personalizados</h3>
      <p>Cada invitación es única, hecha a tu medida.</p>
    </div>
    <div class="feature">
      <h3>Fácil de Compartir</h3>
      <p>Enviala por WhatsApp, correo o redes sociales.</p>
    </div>
    <div class="feature">
      <h3>Detalles Especiales</h3>
      <p>Agregá música, mapas, RSVP y más.</p>
    </div>
  </section>

  <div class="cta">
    <a href="crear.php">Crear invtación</a>
  </div>



</body>
</html>
