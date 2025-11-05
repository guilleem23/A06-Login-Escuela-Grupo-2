<?php
// Procesa el inicio de sesión: recibe POST username y password,
// verifica contra la tabla tbl_usuari y crea la sesión en caso de éxito.

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validaciones básicas
if ($username === '' || $password === '') {
    // CAMBIADO: Aunque el JS lo valida, mantenemos una validación genérica por si JS falla
    header('Location: ../login.php?error=credenciales_invalidas');
    exit;
}

if (strlen($username) > 100 || strlen($password) > 255) {
    header('Location: ../login.php?error=credenciales_invalidas');
    exit;
}

// Conectar a la BD (usa proc/conexion.php)
require_once __DIR__ . '/conexion.php';

// Preparar consulta segura
$sql = 'SELECT idUsuari, username, password, nom, tipusUsuari FROM tbl_usuari WHERE username = :username LIMIT 1';
$stmt = $conn->prepare($sql);
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// CAMBIO 1: Si el usuario NO existe
if (!$user) {
    header('Location: ../login.php?error=usuario_invalido');
    exit;
}

$dbPass = $user['password'];

// Verificar contraseña:
// 1) Si la contraseña almacenada parece un hash válido, usar password_verify()
// 2) Si no, comparar en texto plano (compatibilidad)
$authenticated = false;

if (password_verify($password, $dbPass)) {
    $authenticated = true;
} else {
    // Comparación en texto plano (evitar timing attacks con hash_equals)
    if (is_string($dbPass) && is_string($password) && hash_equals($dbPass, $password)) {
        $authenticated = true;
    }
}

// CAMBIO 2: Si el usuario SÍ existe, pero la contraseña es incorrecta
if (!$authenticated) {
    header('Location: ../login.php?error=password_invalida');
    exit;
}

// Autenticación exitosa: inicializar sesión segura
session_regenerate_id(true);
$_SESSION['user'] = [
    'id' => $user['idUsuari'],
    'username' => $user['username'],
    'name' => $user['nom'],
    'role' => $user['tipusUsuari']
];

// Redirigir a página protegida (ajusta la ruta si tienes otra)
header('Location: ../index.php');
exit;
?>