<?php
// CONTROLLERS/contactoController.php
// Lógica para validar y enviar mensajes de contacto

require_once '../CONFIG/database.php';
require_once '../DATA/contactoDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $mensaje = trim($_POST['mensaje']);

    if ($nombre && $email && $mensaje) {
        guardarMensajeContacto($pdo, $nombre, $email, $mensaje);
        header('Location: ../contacto.php?enviado=1');
    } else {
        header('Location: ../contacto.php?error=1');
    }
    exit;
}
