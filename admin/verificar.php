<?php
session_start();
require_once '../CONFIG/config.php';

// Recogemos datos del formulario
$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';

// Comparamos con los valores definidos
if ($usuario === ADMIN_USER && $clave === ADMIN_PASS) {
    $_SESSION['admin'] = true;
    header('Location: index.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}
