<?php

//incluir archivo de configuración a base de datos


try {
    
    include 'config/config.php';
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);

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