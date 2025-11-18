<?php
// Iniciar sesión para manejar potenciales redirecciones
session_start();

// Comprobar que el método es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

// Incluir la conexión a la BD
require_once __DIR__ . '/conexion.php';

// Recoger y sanear datos del formulario
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$cognoms = isset($_POST['cognoms']) ? trim($_POST['cognoms']) : ''; 
$fechaNacimiento = isset($_POST['fechaNacimiento']) ? trim($_POST['fechaNacimiento']) : ''; 
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

// Validación del lado del servidor 

// Campos vacíos
if (empty($nom) || empty($cognoms) || empty($fechaNacimiento) || empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
    header('Location: ../login.php?form=register&error=campos_vacios');
    exit;
}

// Email válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../login.php?form=register&error=email_invalido');
    exit;
}

// Contraseñas coinciden
if ($password !== $password_confirm) {
    header('Location: ../login.php?form=register&error=password_no_coincide');
    exit;
}

// Longitud de contraseña
if (strlen($password) < 6) {
    header('Location: ../login.php?form=register&error=password_corta');
    exit;
}

// Validaciones de longitud según BBDD 
if (strlen($nom) > 50) {
    header('Location: ../login.php?form=register&error=nom_largo');
    exit;
}
if (strlen($cognoms) > 80) {
    header('Location: ../login.php?form=register&error=cognoms_largo');
    exit;
}
if (strlen($username) > 50) {
    header('Location: ../login.php?form=register&error=username_largo');
    exit;
}
if (strlen($email) > 60) {
    header('Location: ../login.php?form=register&error=email_largo');
    exit;
}

// Validación de fecha
// Función simple para validar formato AAAA-MM-DD
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

if (!validateDate($fechaNacimiento)) {
    header('Location: ../login.php?form=register&error=fecha_invalida');
    exit;
}


// Comprobar si el usuario o email ya existen 
try {
    // Comprobar Username
    $sql = 'SELECT idUsuari FROM tbl_usuari WHERE username = :username LIMIT 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    if ($stmt->fetch()) {
        header('Location: ../login.php?form=register&error=username_existe');
        exit;
    }

    // Comprobar Email
    $sql = 'SELECT idUsuari FROM tbl_usuari WHERE email = :email LIMIT 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        header('Location: ../login.php?form=register&error=email_existe');
        exit;
    }

    // Hashear la contraseña 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario
    // Por defecto, se registra como 'alumne' (tipusUsuari = 3)
    // ACTUALIZADO: Añadidos cognoms y fechaNacimiento
    $sql_insert = "INSERT INTO tbl_usuari (nom, cognoms, fechaNacimiento, username, email, password, tipusUsuari) 
                   VALUES (:nom, :cognoms, :fechaNacimiento, :username, :email, :password, 3)";
    
    $stmt_insert = $conn->prepare($sql_insert);
    
    $stmt_insert->execute([
        ':nom' => $nom,
        ':cognoms' => $cognoms,
        ':fechaNacimiento' => $fechaNacimiento,
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword
    ]);

    // Redirigir con éxito
    header('Location: ../login.php?register_success=1');
    exit;

} catch (PDOException $e) {
    // Manejar error de base de datos
    error_log($e->getMessage()); // Guardar error para depuración
    header('Location: ../login.php?form=register&error=db_error');
    exit;
}
?>