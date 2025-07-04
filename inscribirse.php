<?php
// inscribirse.php
// Formulario para que un cliente se inscriba a una clase

require_once 'CONFIG/database.php';
require_once 'DATA/claseDB.php';
require_once 'DATA/clienteDB.php';

$mensaje = '';
$clases = obtenerClases($pdo); // Mostramos todas las clases

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'] ?? null;
    $id_clase = $_POST['id_clase'] ?? null;

    if (!$id_cliente || !$id_clase) {
        $mensaje = "Debes seleccionar una clase y un cliente.";
    } else {
        // Comprobamos si ya está inscrito
        if (clienteYaInscrito($pdo, $id_cliente, $id_clase)) {
            $mensaje = "Ya estás inscrito en esta clase.";
        } elseif (!hayCupoDisponible($pdo, $id_clase)) {
            $mensaje = "La clase ya ha alcanzado el cupo máximo.";
        } else {
            if (inscribirCliente($pdo, $id_cliente, $id_clase)) {
                $mensaje = "¡Inscripción realizada con éxito!";
            } else {
                $mensaje = "Error al inscribirse.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscribirse a una clase</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <h1>Formulario de Inscripción</h1>

    <?php if ($mensaje): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>

    <form method="post" action="inscribirse.php">
        <label for="id_cliente">Selecciona tu cliente:</label>
        <select name="id_cliente" required>
            <option value="">-- Elige tu nombre --</option>
            <?php foreach (obtenerClientes($pdo) as $cliente): ?>
                <option value="<?= $cliente['id'] ?>">
                    <?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="id_clase">Selecciona una clase:</label>
        <select name="id_clase" required>
            <option value="">-- Elige una clase --</option>
            <?php foreach ($clases as $clase): ?>
                <option value="<?= $clase['id'] ?>">
                    <?= htmlspecialchars($clase['nombre'] . ' (' . $clase['dia_semana'] . ' ' . substr($clase['hora'], 0, 5) . ')') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Inscribirse</button>
    </form>
</body>
</html>
