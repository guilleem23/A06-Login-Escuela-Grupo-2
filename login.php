<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

  <div class="logo-container-left">
    <div class="div-logo">
        <img class="logo" src="img/logo.png" alt="logo">
    </div>
  </div>

  <div class="form-container-right">

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

      <form id="loginForm" action="proc/procesar_login.php" method="post" class="login-form" novalidate>
        <h2 class="form-title">Log in</h2>
        
        <div class="input-field">
          <span class="input-icon"><i class="fas fa-user"></i></span>
          <input class="input" type="text" id="username" name="username" placeholder="Usuario" required>
        </div>
        
        <div class="input-field">
          <span class="input-icon"><i class="fas fa-lock"></i></span>
          <input class="input" type="password" id="password" name="password" placeholder="Contraseña" required>
          </div>
    
        <?php echo $alertHtml; ?>
    
        <div id="clientError" aria-live="polite"></div>
        
        <button class="submit" type="submit">Iniciar sesión</button>
      </form>
    </div>

<script src="js/login-validation.js"></script>
</body>
</html>