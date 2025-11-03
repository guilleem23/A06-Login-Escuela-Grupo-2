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
$displayName = !empty($user['name']) ? $user['name'] : $user['username'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Bienvenido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="p-4">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 text-center">
      <h1 class="mt-5">Bienvenido, <?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?>!</h1>
      <p class="lead">Has iniciado sesión correctamente.</p>

      <!-- Información adicional -->
      <div class="mb-3">
        <strong>Usuario:</strong> <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?><br>
        <strong>Rol:</strong> <?php echo isset($user['role']) ? (int)$user['role'] : 'desconocido'; ?>
      </div>

      <a class="btn btn-primary me-2" href="index.php?logout=1">Cerrar sesión</a>
      <a class="btn btn-secondary" href="login.php">Volver al login</a>
    </div>
  </div>
</div>

</body>
</html>
