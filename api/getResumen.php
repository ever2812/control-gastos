<?php
header('Content-Type: application/json');

$host = 'localhost';
$db   = 'control_gastos';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    // Consulta para obtener totales por tipo
    $sql = "SELECT 
                SUM(CASE WHEN tipo = 'entrada' THEN monto ELSE 0 END) as total_ingresos,
                SUM(CASE WHEN tipo = 'salida' THEN monto ELSE 0 END) as total_egresos
            FROM movimientos";

    $stmt = $pdo->query($sql);
    $resumen = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no hay datos, inicializamos en 0
    $ingresos = $resumen['total_ingresos'] ?? 0;
    $egresos = $resumen['total_egresos'] ?? 0;
    $saldo = $ingresos - $egresos;

    echo json_encode([
        'ingresos' => number_format($ingresos, 2, '.', ''),
        'egresos'  => number_format($egresos, 2, '.', ''),
        'saldo'    => number_format($saldo, 2, '.', '')
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>