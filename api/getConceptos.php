<?php
// Configuración de conexión (ajusta con tus datos)
$host = 'localhost';
$db   = 'control_gastos';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [    
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Consultamos los conceptos activos
    $stmt = $pdo->query("SELECT idConcepto, nombre, tipo FROM conceptos WHERE  estado = 1 ORDER BY tipo, nombre");
    $conceptos = $stmt->fetchAll();

    // Enviamos la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($conceptos);

} catch (\PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>