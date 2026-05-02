<?php
header('Content-Type: application/json');

include 'config/config.php';
//conexion a la base de datos
// $host = 'localhost';
// $db   = 'control_gastos';
// $user = 'root';
// $pass = '';
// $charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}

// Recibir datos del fetch
$data = json_decode(file_get_contents('php://input'), true);

$nombre = trim($data['nombre'] ?? '');
$email  = trim($data['email'] ?? '');
$pass   = $data['password'] ?? '';


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'El formato del email no es válido.']);
    exit;
}

try {
    // Verificar si el email ya existe
    $check = $pdo->prepare("SELECT idUsuario FROM usuarios WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Este correo ya está registrado.']);
        exit;
    }

    // Encriptar contraseña y guardar
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$nombre, $email, $hash])) {
        echo json_encode(['success' => true, 'message' => '¡Cuenta creada con éxito!']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
}