<?php
// clases.php
// Página pública que muestra el calendario de clases con filtro

require_once 'CONFIG/database.php';
require_once 'DATA/claseDB.php'; // Acceso a funciones específicas de clases

// Verificamos si hay un filtro por tipo
$filtro = isset($_GET['tipo']) ? $_GET['tipo'] : null;

// Obtenemos clases desde la base de datos (posiblemente filtradas)
$clases = obtenerClases($pdo, $filtro);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Clases</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <h1>Calendario de Clases</h1>

    <!-- Filtro por tipo de clase -->
    <form method="get" action="clases.php">
        <label for="tipo">Filtrar por tipo:</label>
        <select name="tipo" id="tipo">
            <option value="">-- Todos --</option>
            <option value="Yoga" <?= $filtro == 'Yoga' ? 'selected' : '' ?>>Yoga</option>
            <option value="Spinning" <?= $filtro == 'Spinning' ? 'selected' : '' ?>>Spinning</option>
            <option value="Musculacion" <?= $filtro == 'Musculacion' ? 'selected' : '' ?>>Musculación</option>
        </select>
