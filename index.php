
<?php

session_start();

// Cerrar sesión si se solicita
if (isset($_GET['logout'])) {
  $_SESSION = [];
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }
  session_destroy();
  header('Location: login.php');
  exit;
}

// Si no hay usuario autenticado, redirigir al login
if (empty($_SESSION['user']) || empty($_SESSION['user']['username'])) {
  header('Location: login.php');
  exit;
}

$user = $_SESSION['user'];
// Usar el nombre de usuario para 'Usuario'
$displayName = htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <link rel="stylesheet" href="css/style.css">
 <title>Bienvenido</title>


  <!--  Font Awesome para iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <link rel="stylesheet" href="css/style.css">
</head>
<!-- AÑADIDO: Clase al body para el nuevo fondo -->
<body class="dashboard-body">

  <!-- AÑADIDO: Nueva estructura del dashboard -->
  <div class="dashboard-container">

    <!-- 1. Barra lateral izquierda -->
    <div class="dashboard-sidebar">
      <div class="sidebar-logo-container">
        <!-- NOTA: Asegúrate de que la ruta 'img/logo.png' es correcta -->
        <img src="img/logo.png" alt="Logo Jesuïtes Educació" class="sidebar-logo">
      </div>
      <!-- Fondo decorativo (simulado con CSS) -->
      <div class="sidebar-background"></div>
    </div>

    <!-- 2. Contenido principal derecho -->
    <div class="dashboard-main">
      
      <!-- Encabezado con bienvenida y botón -->
      <div class="dashboard-header">
        <div class="welcome-text">
          <h1 class="welcome-title">BIENVENIDO</h1>
          <span class="welcome-user"><?php echo $displayName; ?></span>
        </div>
        
        <!-- Botón "Back" (Cerrar Sesión) -->
        <a class="dashboard-back-btn" href="index.php?logout=1">
          <i class="fas fa-arrow-left"></i> Cerrar Sesión
        </a>
      </div>

      <!-- Caja de contenido principal -->
      <div class="content-box">
        <!-- Aquí puedes poner el contenido de la página -->
        <p>Has iniciado sesión correctamente.</p>
        <p>
          <strong>Usuario:</strong> <?php echo $displayName; ?><br>
   <strong>Rol:</strong> <?php echo isset($user['role']) ? (int)$user['role'] : 'desconocido'; ?>
        </p>
      </div>

    </div>
  </div>

</body>
</html>