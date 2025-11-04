<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

  <div class="login-container">
    <!-- Columna izquierda con logo -->
    <div class="login-left">
        <div class="div-logo">
            <img class="logo" src="img/logo.png" alt="logo">
        </div>
    </div>

    <!-- Columna derecha con formulario -->
    <div class="login-right">

      <?php
      // Preparar el HTML del error pero no imprimirlo aún
      $alertHtml = '';
      if (!empty($_GET['error'])) {
          $err = htmlspecialchars($_GET['error']);
          $msg = 'Error desconocido.';
          if ($err === 'credenciales_invalidas') $msg = 'Usuario o contraseña incorrectos.';
          $alertHtml = '<div class="alert alert-danger" role="alert" style="margin:0 0 1rem 0;">' . $msg . '</div>';
      }
      ?>

        <!-- Form: se añade id y novalidate -->
        <form id="loginForm" action="proc/procesar_login.php" method="post" class="login-form" novalidate>
          <h2 class="form-title">Iniciar Sesión</h2>
          <div class="input-field">
            <input class="input" type="text" id="username" name="username" placeholder="Usuario" required>
          </div>
          <div class="input-field">
            <input class="input" type="password" id="password" name="password" placeholder="Contraseña" required>
          </div>
      
          <!-- Mostrar el mensaje de error del servidor justo debajo del campo contraseña -->
          <?php echo $alertHtml; ?>
      
          <!-- Contenedor para errores de validación en cliente -->
          <div id="clientError" aria-live="polite"></div>
      
          <button class="submit" type="submit">Iniciar Sesión</button>
        </form>
      </div>
    </div>

  </div>

<!-- Incluir archivo JS externo -->
<script src="js/login-validation.js"></script>
</body>

</html>

