<?php
session_start();
require_once 'conexion.php';

// Recibe usuario y contraseña por POST
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validación mínima: campos obligatorios
if ($username === '' || $password === '') {
    header('Location: ../login.php?error=campos_vacios');
    exit;
}

// Consultar usuario por username
$stmt = $conn->prepare('SELECT idUsuari, username, nom, password FROM tbl_usuari WHERE username = :username LIMIT 1');
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // usuario no encontrado
    header('Location: ../login.php?error=credenciales_invalidas');
    exit;
}

$dbPass = $user['password'];

// Comprobar contraseña: si está hasheada usar password_verify, si no comparar en claro
$ok = false;
if ($dbPass !== '' && password_verify($password, $dbPass)) {
    $ok = true;
} elseif (hash_equals($dbPass, $password)) {
    $ok = true;
}

if ($ok) {
    // Login correcto: guardar sesión y redirigir a index
    session_regenerate_id(true);
    // Guardamos ambas claves por compatibilidad con el código existente
    $_SESSION['idUsuari'] = $user['idUsuari'];
    $_SESSION['id_usuario'] = $user['idUsuari'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['loginok'] = true;
    header('Location: ../index.php');
    exit;
} else {
    // contraseña incorrectaaaaaaaa
    header('Location: ../login.php?error=credenciales_invalidas');
    exit;
}

?>
