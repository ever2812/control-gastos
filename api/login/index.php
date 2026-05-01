<?php

header('Content-Type: application/json');

//conexion a la base de datos
$host = 'localhost';
$db   = 'control_gastos';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

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

$data = json_decode(file_get_contents('php://input'), true);

$stmt = $pdo->prepare("SELECT idUsuario, nombre, password_hash FROM usuarios WHERE email = ?");
$stmt->execute([$data['emailUsuario']]);
$user = $stmt->fetch();

if ($user && password_verify($data['psdUsuario'], $user['password_hash'])) {
    //se incia la sesión y se guardan los datos del usuario en la sesión

    session_start();
    $_SESSION['user_id'] = $user['idUsuario'];
    $_SESSION['user_nombre'] = $user['nombre'];

    echo json_encode(['success' => true,"idUser" => $user['idUsuario']]);

} else {
    echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
}