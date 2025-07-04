<?php
// DATA/clienteDB.php
// Funciones relacionadas con clientes y sus inscripciones

function obtenerClientes($pdo) {
    $stmt = $pdo->query("SELECT id, nombre, apellido FROM clientes ORDER BY nombre");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function clienteYaInscrito($pdo, $id_cliente, $id_clase) {
    $sql = "SELECT COUNT(*) FROM inscripciones_clases WHERE id_cliente = ? AND id_clase = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_cliente, $id_clase]);
    return $stmt->fetchColumn() > 0;
}

function hayCupoDisponible($pdo, $id_clase) {
    // Obtenemos cupo máximo y cuántos inscritos hay
    $sql = "
        SELECT cupo_maximo,
               (SELECT COUNT(*) FROM inscripciones_clases WHERE id_clase = ?) AS inscritos
        FROM clases WHERE id = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_clase, $id_clase]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row && $row['inscritos'] < $row['cupo_maximo'];
}

function inscribirCliente($pdo, $id_cliente, $id_clase) {
    $sql = "INSERT INTO inscripciones_clases (id_cliente, id_clase, fecha_inscripcion) VALUES (?, ?, CURDATE())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_cliente, $id_clase]);
}
