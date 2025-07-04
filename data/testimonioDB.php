<?php
// DATA/testimonioDB.php
// Funciones relacionadas con testimonios

function guardarTestimonio($pdo, $id_cliente, $mensaje) {
    $sql = "INSERT INTO testimonios (id_cliente, mensaje, fecha, visible) VALUES (?, ?, CURDATE(), 0)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_cliente, $mensaje]);
}

function obtenerTestimoniosVisibles($pdo) {
    $sql = "
        SELECT t.mensaje, t.fecha, c.nombre
        FROM testimonios t
        JOIN clientes c ON t.id_cliente = c.id
        WHERE t.visible = 1
        ORDER BY t.fecha DESC
    ";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
