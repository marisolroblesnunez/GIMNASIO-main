<?php
// CONTROLLERS/testimonioController.php
// Controlador para manejar el envío de testimonios

require_once '../CONFIG/database.php';
require_once '../DATA/testimonioDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'] ?? null;
    $mensaje = trim($_POST['mensaje']);

    if ($id_cliente && $mensaje) {
        guardarTestimonio($pdo, $id_cliente, $mensaje);
        header('Location: ../testimonios.php?ok=1');
    } else {
        header('Location: ../testimonios.php?error=1');
    }
    exit;
}
