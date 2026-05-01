<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Acceso denegado']));
}

$idUsuario = $_SESSION['user_id'];


header('Content-Type: application/json');

$host = 'localhost';
$db   = 'control_gastos';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    // Consulta para obtener totales por tipo
    $mesSeleccionado = $_GET['mes'] ?? date('Y-m'); // Por defecto mes actual

    $sql = "SELECT 
            SUM(CASE WHEN tipo = 'entrada' THEN monto ELSE 0 END) as total_ingresos,
            SUM(CASE WHEN tipo = 'salida' THEN monto ELSE 0 END) as total_egresos
        FROM movimientos 
        WHERE DATE_FORMAT(fecha_operacion, '%Y-%m') = :mes
        AND idUsuario = :idUsuario";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':mes' => $mesSeleccionado, ':idUsuario' => $idUsuario]);
    $resumen = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no hay datos, inicializamos en 0
    $ingresos = $resumen['total_ingresos'] ?? 0;
    $egresos = $resumen['total_egresos'] ?? 0;
    $saldo = getSaldo($idUsuario);

    echo json_encode([
        'ingresos' => number_format($ingresos, 2, '.', ''),
        'egresos'  => number_format($egresos, 2, '.', ''),
        'saldo'    => number_format($saldo, 2, '.', '')
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

function getSaldo($idUsuario)
{

    $host = 'localhost';
    $db   = 'control_gastos';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $pdo2 = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $sql = "SELECT 
            SUM(CASE WHEN tipo = 'entrada' THEN monto ELSE 0 END) as total_ingresos,
            SUM(CASE WHEN tipo = 'salida' THEN monto ELSE 0 END) as total_egresos
        FROM movimientos 
        WHERE idUsuario = :idUsuario";

    $stmt = $pdo2->prepare($sql);
    $stmt->execute([':idUsuario' => $idUsuario]);
    $resumen = $stmt->fetch(PDO::FETCH_ASSOC);

    $ingresos = $resumen['total_ingresos'] ?? 0;
    $egresos = $resumen['total_egresos'] ?? 0;

    return number_format($ingresos - $egresos, 2, '.', '');
}
