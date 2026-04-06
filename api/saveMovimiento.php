<?php
header('Content-Type: application/json');

// Configuración de conexión
$host = 'localhost';
$db   = 'control_gastos';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    // Recibir datos del POST (JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        throw new Exception("No se recibieron datos válidos.");
    }

    // Preparar la inserción
    $sql = "INSERT INTO movimientos (idUsuario,idConcepto, tipo, monto, descripcion, fecha_operacion) 
            VALUES (:idUsuario,:idConcepto, :tipo, :monto, :descripcion, :fecha)";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':idUsuario'   => $data['idUsuario'],
        ':idConcepto'  => $data['concepto_id'],
        ':tipo'        => $data['tipo'],
        ':monto'       => $data['monto'],
        ':descripcion' => $data['descripcion'],
        ':fecha'       => date('Y-m-d') // O puedes recibir una fecha del modal
    ]);

    echo json_encode(['success' => true, 'message' => 'Movimiento guardado']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>