<?php
// Preparar el HTML del error de LOGIN
$loginAlertHtml = '';
// CAMBIADO: Comprobación más segura para el error de login
if (!empty($_GET['error']) && !isset($_GET['form'])) {
    $err = htmlspecialchars($_GET['error']);
    $msg = 'Error desconocido.';
    if ($err === 'credenciales_invalidas') $msg = 'Usuario o contraseña incorrectos.';
    
    // AÑADIDO: Nuevos mensajes de error específicos
    if ($err === 'usuario_invalido') $msg = 'El usuario introducido no existe.';
    if ($err === 'password_invalida') $msg = 'La contraseña es incorrecta.';
    
    $loginAlertHtml = '<div class="alert alert-danger" role="alert" style="margin:0 0 1rem 0;">' . $msg . '</div>';
}

// Preparar el HTML del error o éxito de REGISTRO
$registerAlertHtml = '';
if (!empty($_GET['register_success'])) {
    $registerAlertHtml = '<div class="alert alert-success" role="alert" style="margin:0 0 1rem 0;">¡Registro completado! Ya puedes iniciar sesión.</div>';
// CAMBIADO: Comprobación más segura para el error de registro
} elseif (isset($_GET['form']) && $_GET['form'] === 'register' && !empty($_GET['error'])) {
    $err = htmlspecialchars($_GET['error']);
    $msg = 'Error desconocido en el registro.';
    // Errores existentes
    if ($err === 'campos_vacios') $msg = 'Todos los campos son obligatorios.';
    if ($err === 'email_invalido') $msg = 'El formato del email no es válido.';
    if ($err === 'password_no_coincide') $msg = 'Las contraseñas no coinciden.';
    if ($err === 'password_corta') $msg = 'La contraseña debe tener al menos 6 caracteres.';
    if ($err === 'username_existe') $msg = 'Este nombre de usuario ya está en uso.';
    if ($err === 'email_existe') $msg = 'Este email ya está registrado.';
    // Nuevos errores (longitud y fecha)
    if ($err === 'nom_largo') $msg = 'El nombre no puede tener más de 50 caracteres.';
    if ($err === 'cognoms_largo') $msg = 'Los apellidos no pueden tener más de 80 caracteres.';
    if ($err === 'username_largo') $msg = 'El usuario no puede tener más de 50 caracteres.';
    if ($err === 'email_largo') $msg = 'El email no puede tener más de 60 caracteres.';
    if ($err === 'fecha_invalida') $msg = 'El formato de la fecha no es válido (debe ser AAAA-MM-DD).';
    if ($err === 'db_error') $msg = 'Error al procesar la solicitud. Inténtalo de nuevo.';
    
    $registerAlertHtml = '<div class="alert alert-danger" role="alert" style="margin:0 0 1rem 0;">' . $msg . '</div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  
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

    <div class="form-toggle">
      <button id="toggleToLogin" class="toggle-btn active">Iniciar Sesión</button>
      <button id="toggleToRegister" class="toggle-btn">Registrarse</button>
    </div>

    <div id="loginFormContainer">
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
    
        <?php echo $loginAlertHtml; ?>
    
        <div id="clientErrorLogin" class="client-error" aria-live="polite"></div>
        
        <button class="submit" type="submit">Iniciar sesión</button>
      </form>
    </div>

    <div id="registerFormContainer" class="form-hidden">
      <form id="registerForm" action="proc/procesar_register.php" method="post" class="login-form" novalidate>
        <h2 class="form-title">Registro</h2>

        <div class="input-field">
          <span class="input-icon"><i class="fas fa-user-circle"></i></span>
          <input class="input" type="text" id="reg_nom" name="nom" placeholder="Nombre" required>
        </div>
        
        <div class="input-field">
          <span class="input-icon"><i class="fas fa-user-friends"></i></span>
          <input class="input" type="text" id="reg_cognoms" name="cognoms" placeholder="Apellidos" required>
        </div>
        
        <div class="input-field">
          <span class="input-icon"><i class="fas fa-calendar-alt"></i></span>
          <input class="input" type="date" id="reg_edad" name="edad" placeholder="Fecha de Nacimiento" required>
        </div>

        <div class="input-field">
          <span class="input-icon"><i class="fas fa-user"></i></span>
          <input class="input" type="text" id="reg_username" name="username" placeholder="Usuario (para login)" required>
        </div>

        <div class="input-field">
          <span class="input-icon"><i class="fas fa-envelope"></i></span>
          <input class="input" type="email" id="reg_email" name="email" placeholder="Email" required>
        </div>
        
        <div class="input-field">
          <span class="input-icon"><i class="fas fa-lock"></i></span>
          <input class="input" type="password" id="reg_password" name="password" placeholder="Contraseña" required>
        </div>

        <div class="input-field">
          <span class="input-icon"><i class="fas fa-lock"></i></span>
          <input class="input" type="password" id="reg_password_confirm" name="password_confirm" placeholder="Confirmar Contraseña" required>
        </div>
    
        <?php echo $registerAlertHtml; ?>
    
        <div id="clientErrorRegister" class="client-error" aria-live="polite"></div>
        
        <button class="submit" type="submit">Registrarse</button>
      </form>
    </div>

  </div>

<script src="js/login-validation.js"></script>
</body>
</html>