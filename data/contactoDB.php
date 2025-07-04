<?php
// DATA/contactoDB.php
// Función para insertar mensajes en la tabla mensajes_contacto

function guardarMensajeContacto($pdo, $nombre, $email, $mensaje) {
    $sql = "INSERT INTO mensajes_contacto (nombre, email, mensaje, fecha) VALUES (?, ?, ?, CURDATE())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nombre, $email, $mensaje]);
}
function obtenerMensajesContacto($pdo) {
    $sql = "SELECT nombre, email, mensaje, fecha FROM mensajes_contacto ORDER BY fecha DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
