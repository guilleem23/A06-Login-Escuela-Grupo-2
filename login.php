<<<<<<< HEAD


=======
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

  <!-- Botón para volver atrás -->
  <div class="back-link">
    <a class="boton-atras" href="./index.html">Volver atrás</a>
  </div>

  <div class="login-container">
    <!-- Columna izquierda con logo -->
    <div class="login-left">
        <div class="div-logo">
            <img class="logo" src="img/logo.png" alt="logo">
        </div>
    </div>

    <!-- Columna derecha con formulario -->
    <div class="login-right">
      <form action="../proc/procesar_login.php" method="post" class="login-form">
        <h2 class="form-title">Iniciar Sesión</h2>
        <div class="input-field">
          <input class="input" type="text" id="username" name="username" placeholder="Usuario" required>
        </div>
        <div class="input-field">
          <input class="input" type="password" id="password" name="password" placeholder="Contraseña" required>
        </div>
        <button class="submit" type="submit">Iniciar Sesión</button>
      </form>
    </div>
  </div>

</body>
</html>
>>>>>>> 46488ca841d44e31010adb87293e58c6469f82d2
