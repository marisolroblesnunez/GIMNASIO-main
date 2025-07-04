<?php
// testimonios.php
// Página donde los clientes pueden dejar una opinión y se muestran los testimonios validados

require_once 'CONFIG/database.php';
require_once 'DATA/testimonioDB.php';
require_once 'DATA/clienteDB.php'; // Para seleccionar cliente

$mensaje = '';

// Guardar testimonio si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'] ?? null;
    $mensaje_testimonio = trim($_POST['mensaje']);

    if (!$id_cliente || !$mensaje_testimonio) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        if (guardarTestimonio($pdo, $id_cliente, $mensaje_testimonio)) {
            $mensaje = "Gracias por tu opinión. Será publicada tras validación.";
        } else {
            $mensaje = "Error al enviar tu testimonio.";
        }
    }
}

// Obtener testimonios públicos (visible = 1)
$testimonios = obtenerTestimoniosVisibles($pdo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Testimonios</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <h1>Opiniones de nuestros clientes</h1>

    <!-- Lista de testimonios -->
    <?php if (empty($testimonios)): ?>
        <p>No hay testimonios aún.</p>
    <?php else: ?>
        <?php foreach ($testimonios as $testimonio): ?>
            <div class="testimonio">
                <p><strong><?= htmlspecialchars($testimonio['nombre']) ?>:</strong></p>
                <p><?= nl2br(htmlspecialchars($testimonio['mensaje'])) ?></p>
                <small><?= $testimonio['fecha'] ?></small>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h2>Deja tu opinión</h2>
    <?php if ($mensaje): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>

    <form method="post" action="testimonios.php">
        <label for="id_cliente">Tu nombre:</label><br>
        <select name="id_cliente" required>
            <option value="">-- Selecciona tu nombre --</option>
            <?php foreach (obtenerClientes($pdo) as $cliente): ?>
                <option value="<?= $cliente['id'] ?>">
                    <?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="mensaje">Tu opinión:</label><br>
        <textarea name="mensaje" rows="4" required></textarea><br><br>

        <button type="submit">Enviar Testimonio</button>
    </form>
</body>
</html>
