<?php

    //require_once 'config.php'; // Aquí ya tienes session_start() y la conexión

    session_start();

    if (isset($_SESSION['user_id'])) {
        echo json_encode([
            'logged' => true,
            'user_id' => $_SESSION['user_id'],
            'nombre' => $_SESSION['user_nombre']
        ]);
    } else {
        echo json_encode(['logged' => false]);
    }