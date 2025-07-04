<?php
// DATA/claseDB.php
// Funciones para consultar la base de datos relacionadas con clases

function obtenerClases($pdo, $tipo = null) {
    // Esta consulta usa subconsulta para contar inscritos
    $sql = "
        SELECT 
            c.id, c.nombre, c.descripcion, c.dia_semana, c.hora, c.duracion_minutos, c.cupo_maximo,
            (SELECT COUNT(*) FROM inscripciones_clases ic WHERE ic.id_clase = c.id) AS inscritos
        FROM clases c
    ";

    $params = [];

    // Aplicamos filtro por tipo si se ha definido
    if ($tipo) {
        $sql .= " WHERE c.nombre LIKE :tipo";
        $params[':tipo'] = "%$tipo%";
    }

    $sql .= " ORDER BY FIELD(c.dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'), c.hora";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
