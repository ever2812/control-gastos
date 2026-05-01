<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Acceso denegado']));
}

$idUsuario = $_SESSION['user_id'];

// Configuración de conexión (ajusta con tus credenciales)
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
    
    // Consulta con JOIN para traer el nombre del concepto
    $mesSeleccionado = $_GET['mes'] ?? date('Y-m'); // Por defecto mes actual
    
    $sql = "SELECT 
                m.idMovimiento, 
                m.monto, 
                m.descripcion, 
                m.tipo, 
                m.fecha_operacion, 
                c.nombre AS concepto_nombre
            FROM movimientos m
            JOIN conceptos c ON m.idConcepto = c.idConcepto
            WHERE DATE_FORMAT(fecha_operacion, '%Y-%m') = :mes
            AND m.idUsuario = :idUsuario            
            ORDER BY m.fecha_operacion DESC, m.creado_en DESC 
            LIMIT 20";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':mes' => $mesSeleccionado, ':idUsuario' => $idUsuario]);
    $movimientos = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($movimientos);

} catch (\PDOException $e) {
    header('HTTP/1.1 500 Internal Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>