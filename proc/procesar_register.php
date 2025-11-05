<?php
// Iniciar sesión para manejar potenciales redirecciones
session_start();

// 1. Comprobar que el método es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

// 2. Incluir la conexión a la BD
require_once __DIR__ . '/conexion.php';

// 3. Recoger y sanear datos del formulario
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$cognoms = isset($_POST['cognoms']) ? trim($_POST['cognoms']) : ''; // NUEVO
$edad = isset($_POST['edad']) ? trim($_POST['edad']) : ''; // NUEVO
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

// 4. Validación del lado del servidor (Backend)

// 4.1. Campos vacíos
if (empty($nom) || empty($cognoms) || empty($edad) || empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
    header('Location: ../login.php?form=register&error=campos_vacios');
    exit;
}

// 4.2. Email válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../login.php?form=register&error=email_invalido');
    exit;
}

// 4.3. Contraseñas coinciden
if ($password !== $password_confirm) {
    header('Location: ../login.php?form=register&error=password_no_coincide');
    exit;
}

// 4.4. Longitud de contraseña (ej. mínimo 6 caracteres)
if (strlen($password) < 6) {
    header('Location: ../login.php?form=register&error=password_corta');
    exit;
}

// 4.5. Validaciones de longitud según BBDD (NUEVO)
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

// 4.6. Validación de fecha (NUEVO)
// Función simple para validar formato AAAA-MM-DD
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

if (!validateDate($edad)) {
    header('Location: ../login.php?form=register&error=fecha_invalida');
    exit;
}


// 5. Comprobar si el usuario o email ya existen (Atomicidad)
try {
    // 5.1. Comprobar Username
    $sql = 'SELECT idUsuari FROM tbl_usuari WHERE username = :username LIMIT 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    if ($stmt->fetch()) {
        header('Location: ../login.php?form=register&error=username_existe');
        exit;
    }

    // 5.2. Comprobar Email
    $sql = 'SELECT idUsuari FROM tbl_usuari WHERE email = :email LIMIT 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        header('Location: ../login.php?form=register&error=email_existe');
        exit;
    }

    // 6. Hashear la contraseña (¡MUY IMPORTANTE!)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 7. Insertar el nuevo usuario
    // Por defecto, se registra como 'alumne' (tipusUsuari = 3)
    // ACTUALIZADO: Añadidos cognoms y edad
    $sql_insert = "INSERT INTO tbl_usuari (nom, cognoms, edad, username, email, password, tipusUsuari) 
                   VALUES (:nom, :cognoms, :edad, :username, :email, :password, 3)";
    
    $stmt_insert = $conn->prepare($sql_insert);
    
    // ACTUALIZADO: Añadidos binds para cognoms y edad
    $stmt_insert->execute([
        ':nom' => $nom,
        ':cognoms' => $cognoms,
        ':edad' => $edad,
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword
    ]);

    // 8. Redirigir con éxito
    header('Location: ../login.php?register_success=1');
    exit;

} catch (PDOException $e) {
    // Manejar error de base de datos
    error_log($e->getMessage()); // Guardar error para depuración
    header('Location: ../login.php?form=register&error=db_error');
    exit;
}
?>